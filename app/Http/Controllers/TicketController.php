<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Turn;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(){

    }

    public function register(){
        return view('ticket.ticketRegister');
    }

    public function save(Request $request){    

        $validate = $this->validate($request, [ 'number_ticket'=>'required|integer|unique:tickets',
                                                'name_ticket'  =>'required',                                             
                                                ]);
        
        
        $number         = $request->input('number_ticket');
        $name           = $request->input('name_ticket');
        $description    = $request->input('description_ticket');

        $ticket = new Ticket();
        $ticket->number_ticket      = $number;
        $ticket->name_ticket        = $name;
        $ticket->description_ticket = $description;

        $ticket->save();

        return redirect()->route('config')->with(['message'=>'Taquilla Registrada']);
    }

    public function detail($id){

        $ticket = Ticket::find($id);

        return view('ticket.ticketDetail', ['ticket'=>$ticket]);
    }

    public function update (Request $request){

        $id = $request->input('id');

        $ticket = Ticket::find($id);

        $validate = $this->validate($request, ['name_ticket'  =>'required',                                             
                                                ]);

        $name           = $request->input('name_ticket');
        $description    = $request->input('description_ticket');

        $ticket->name_ticket        = $name;
        $ticket->description_ticket = $description;

        $ticket->update();

        return redirect()->route('config')->with(['message'=>'Taquilla Actualizada']);

    }

    public function delete(Request $request){

        $id = $request->input('id');

        $ticket = Ticket::find($id);
        $ticket->delete();
        
        return redirect()->route('config')->with(['message', 'Taquilla Eliminada']);
    }

    public function statusTicket($id, $status){

        $ticket = Ticket::find($id);

        $ticket->status_ticket = $status;

        $ticket->update();

        return redirect()->route('config')->with(['message'=>'Estado de la taquilla Actualizado']);
    }
    public function ticketResumen($id){

        $today = Carbon::today();
        $atendidos=DB::table('turns')->whereDate('created_at', $today)->where('ticket_id',$id)->where('turn_status','Atendido')->count();
        $espera=DB::table('turns')->whereDate('created_at', $today)->where('ticket_id',$id)->where('turn_status','En espera')->count();
        $atencion=DB::table('turns')->whereDate('created_at', $today)->where('ticket_id',$id)->where('turn_status','Iniciado')->count();

        $ticket = Ticket::find($id);
        return view('ticket.ticketResumen', ['ticket'=>$ticket,
                                            'atendidos'=>$atendidos,
                                            'espera'=>$espera,
                                            'atencion'=>$atencion,
                                            ]);
    }
    public function oficinasActivas(Request $request){
        $id_ticket = $request->input('id_ticket');
        
        $oficinasActivas = Ticket::where('status_ticket', 'Activa')->where('id', '<>',$id_ticket )->get();

        return response()->json(array('oficinasActivas'=>$oficinasActivas,
                                       ));
    }
    
}
