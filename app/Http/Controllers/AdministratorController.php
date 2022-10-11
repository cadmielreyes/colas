<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use App\Turn;
use App\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class AdministratorController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function panel()
  {

    $ticketAll = Ticket::all();
    $ticket = null;
     $turnWaiting = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->join("tickets", "tickets.id", "=", "ticket_turn.ticket_id")/*->with(['tickets','clients'])*/->where('turn_status', 'En Espera')/*->limit(5)*/->get();
     
    foreach($turnWaiting as $turnWaitin){
       echo $turnWaitin->name_ticket;
      /*foreach($turnWaitin->tickets as $turnWaiti){
      return $turnWaiti;
      }*/
    }

    /*return view('administrator.panel', [
      'ticketAll'  => $ticketAll,
      'ticket'     => $ticket
    ]);*/
  }

  public function selectedPanel($id)
  {

    $ticketAll  = Ticket::where('status_ticket', 'Activa')->get();;
    $ticket     = Ticket::find($id);
    $user = Auth::user();

    $notifications = auth()->user()->unreadNotifications;

    //return $turnFirst  = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where( 'turn_status','En Espera')->where('ticket_id', $id)->orWhere('turn_status','Llamado')->where('ticket_id', $id)->orWhere('turn_status','Iniciado')->where('ticket_id', $id)->first();

    $turns  = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where('turn_status', 'En Espera')->orWhere('turn_status', 'Llamado')->where('ticket_id', $id)->orWhere('turn_status', 'Iniciado')->where('ticket_id', $id)->get();
    //var_dump($turns);
    // die();

    $turnpref = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where('turn_type', 'Preferencial')->where('turn_status', 'En Espera')->where('ticket_id', $id)->first();
    if ($turnpref) {
      $turnFirst = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where('turn_type', 'Preferencial')->where('turn_status', 'En Espera')->where('ticket_id', $id)->first();
    } else {

      $turnFirst  = Turn::join("ticket_turn", "ticket_turn.turn_id", "=", "turns.id")->where('ticket_id', $id)->Where('turn_status', 'En Espera')->where('ticket_id', $id)->orWhere('turn_status', 'Llamado')->where('ticket_id', $id)->orWhere('turn_status', 'Iniciado')->where('ticket_id', $id)->first();
    }

    return view('administrator.panel', [
      'ticket'       => $ticket,
      'turns'        => $turns,
      'ticketAll'    => $ticketAll,
      'first'        => $turnFirst,
      'user'         => $user,
      'notifications' => $notifications,
    ]);
  }

  public function turn()
  {

    $video = Video::all();
    $videoPanel = null;

    return view('turn.turnPanel', [
      'video'   => $video,
      'videoPanel' => $videoPanel
    ]);
  }

  public function config()
  {

    $ticket = Ticket::all();
    $user   = User::all();

    return view('administrator.config', [
      'users' => $user,
      'tickets' => $ticket
    ]);
  }
  public function resumen()
  {
    $tickets = Ticket::orderBy('name_ticket', 'asc')->get();
    return view('administrator.resumen', [
                                        'tickets'=>$tickets,
                                        ]);	
  }
  public function notification(Request $request)
  {
    $notifications = auth()->user()->unreadNotifications;
    return response()->json(array('notifications'=>$notifications,
                                       ));
  }
}
