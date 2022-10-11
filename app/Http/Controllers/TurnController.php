<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Events\NotificationEvent;
use App\Notifications\Alerta;
use App\Ticket;
use App\Turn;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mpdf\Mpdf;

class TurnController extends Controller
{


    public function index($ci){

        
    }

    public function turnTicket($ci, $id){
        
        $ci = $ci;
        $id = $id;

        return view('turn.turnType', ['ci'=> $ci, 'id'=>$id]);
    }

    public function generatedNumberTurn()
    {
        $random_code = Turn::orderBy('random_code', 'desc')->first();

        if ($random_code != null) {
            
            $number = explode('-', $random_code->random_code);//LUEGO SOLO BUSCO LO NUMEROS
            $number_integer = (int)$number[1];// [1] LOS COVIERTOS A UN ENTERO PARA PORDER SUMARLA 1 Y SEGUIR LA SECUENCIA
            $number_generated = strtoupper('UH' . "-" . str_pad($number_integer + 1, 4, '0', STR_PAD_LEFT));
            return $number_generated;
        
        } else {
            $number_generated = strtoupper('UH' . "-" . str_pad(1, 4, '0', STR_PAD_LEFT));
            return $number_generated;
        }
    }

    public function save($ci, $id, $turn){

        $client_id  = $ci;
        $ticket_id  = $id;
        $turn_type  = $turn;

        $generatedTurn  = new Turn();
        $turnController = new TurnController();

        $queryTurn= null;//Turn::where(['client_id'=>$ci, 'ticket_id'=>$id, 'turn_status'=>'En Espera'])->first();
        
        if($queryTurn == null){

            $generatedTurn->random_code = $turnController->generatedNumberTurn();
            $generatedTurn->client_id   = $client_id;
            //$generatedTurn->ticket_id   = $ticket_id;
            $generatedTurn->turn_type   = $turn_type;

            $generatedTurn->save();

            //guardar en la tabla pivot
            $ultimo_registro=Turn::latest('created_at')->first();
            $turn_pivot=Turn::find($ultimo_registro->id);
            $turn_pivot->tickets()->attach($ticket_id);

            //return $turn_pivot->tickets->id;

            //event(new NotificationEvent($post));

            $ticket= Ticket::find($id);
            //$user=User::where('ticket_id', $ticket->id)->get();
            //auth()->user()->notify(new Alerta($generatedTurn));
            User::where('ticket_id', $ticket->id)->each(function(User $user) use ($generatedTurn){
                $user->notify(new Alerta($generatedTurn));
            });

            $query = $generatedTurn->orderBy('id','desc')->first();
            return view('ticket.ticket',['turn_pivot'=> $turn_pivot]);
        
             //$html = view('ticket.ticket',['turn'=> $query]);
        
             //$pdf = new Mpdf(['mode' => 'utf-8', 'format' => [190, 200]]);
             //$pdf->WriteHTML($html);
             //$pdf->Output();
        
        }else{
            return redirect()->route('ticket.turn',['ci'=>$ci, 'id'=>$id])->with(['message'=>'¡Ya tienes un turno en proceso!, espere su turno']);  
        }
    }

    public function turnCallMe(Request $request){
        
        $turnCall = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->join("tickets", "tickets.id", "=", "ticket_turn.ticket_id")->with(['tickets','clients'])->where('turn_status', 'Llamado')->orderBy('turn_status', 'desc')->get();
        
        return response()->json(array('call'=>$turnCall,
                                       ));
    }

    public function turnWaiting(Request $request){
        
     $turnWaiting = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->join("tickets", "tickets.id", "=", "ticket_turn.ticket_id")->with(['tickets','clients'])->where('turn_status', 'En Espera')->limit(5)->get();

        return response()->json(array('waiting'=>$turnWaiting,
                                       ));
    }

    public function turnAttending(Request $request){
        
        //$turnAttend = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->with(['tickets', 'clients'])->where('turn_status', 'Iniciado')->limit(5)->get();
        $turnAttend = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->join("tickets", "tickets.id", "=", "ticket_turn.ticket_id")->with(['tickets','clients'])->where('turn_status', 'Iniciado')->limit(5)->get();


        return response()->json(array('attend'=>$turnAttend,
                                       ));
    }

    public function turnCall(Request $request){

        $id = $request->input('idTurn');

        DB::table("ticket_turn")->where("id",$id)->update(['turn_status' => "Llamado"]);
        
    }

     public function turnStart(Request $request){

        $id = $request->input('idTurn');

        DB::table("ticket_turn")->where("id",$id)->update(['turn_status' => "Iniciado"]);
        
    }

    public function turnFinally(Request $request){

        $id = $request->input('idTurn');

        DB::table("ticket_turn")->where("id",$id)->update(['turn_status' => "Atendido"]);

    }

    public function turnCancel(Request $request){

        $id = $request->input('idTurn');
        
        DB::table("ticket_turn")->where("id",$id)->update(['turn_status' => "Cancelado"]);
        
    }

    public function turnReset(Request $request){

        $turn= Turn::where('turn_status', 'En Espera')->orWhere('turn_status', 'Llamado')->orWhere('turn_status', 'Iniciado')->get();

        foreach ($turn as $turns) {

            $turns->turn_status = "Cancelado";
            $turns->update();
        }
 
    }

    public function turnResetTicket(Request $request){

        $id = $request->input('idReset');

        $turn= Turn::where('ticket_id', $id)->where('turn_status', 'En Espera')->where('ticket_id', $id)->orWhere('turn_status', 'Llamado')->where('ticket_id', $id)->orWhere('turn_status', 'Iniciado')->get();

        foreach ($turn as $turns) {

            $turns->turn_status = "Cancelado";
            $turns->update();
        }
 
    }

    public function turnActualizar(Request $request){

        $id = $request->input('id_ticket');
        $turns  = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->join('clients', 'turns.client_id', '=', 'clients.id')->select('ticket_turn.created_at','turns.random_code','clients.ci_client')->where('ticket_id', $id)->Where('turn_status','En Espera')->orWhere('turn_status','Llamado')->where('ticket_id', $id)->orWhere('turn_status','Iniciado')->where('ticket_id', $id)->get();

        $turnpref = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where('turn_type','Preferencial')->where('turn_status', 'En Espera')->where('ticket_id', $id)->first();
          if($turnpref){
            $turnFirst = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where('turn_type','Preferencial')->where('turn_status', 'En Espera')->where('ticket_id', $id)->first();
          }
          else{

          $turnFirst  = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where( 'turn_status','En Espera')->where('ticket_id', $id)->orWhere('turn_status','Llamado')->where('ticket_id', $id)->orWhere('turn_status','Iniciado')->where('ticket_id', $id)->first();
          }
        return response()->json(array('turns'=>$turns,
                                        'first'=>$turnFirst,
                                       ));
        
    }
    public function derivar(Request $request){

        $id_pivot = $request->input('id_turn');
        $pivot=DB::table("ticket_turn")->where("id",$id_pivot)->get();

        $id_oficina = $request->input('oficina');

        
        DB::table("ticket_turn")->where("id",$id_pivot)->update(['turn_status' => "Atendido"]);

        $turn_pivot=Turn::find($pivot[0]->turn_id);
        $turn_pivot->tickets()->attach($id_oficina );

        return redirect()->back()->with('success','Usuario derivado correctamente');
    }
    public function no_atendido(){
        DB::table("ticket_turn")->where('turn_status',"En Espera")->update(['turn_status' => "No Atendido"]);
    }
    
    
}
