<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function update(Request $request){

        $id   =  $request->input('id');
        $user = User::find($id);

        $validate = $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]); 
        
        
        $name       = $request->input('name');
        $email      = $request->input('email');
        $ticket_id      = $request->input('ticket_id');

        $user->name     = $name;
        $user->email    = $email;
        $user->ticket_id    = $ticket_id;

        $user->update();

        return redirect()->route('config')->with(['message'=>'Actualización Exitosa']);

    }

    public function passwordUpdate(Request $request){

        $id = $request->input('id');

        $rules = $this->validate($request,['mypassword'=>'required',
                                              'password'  =>'requiered|confirmed|min:6|max:18']);

        $message = ['mypassword.required' => 'El campo es requerido',
                    'password.required'   => 'El campo es requerido',
                    'password.confirmed'  => 'La contraseña no coinciden',
                    'password.min'        => 'El minimo son 6 caracteres',
                    'password.max'        => 'El maximo son 18 caracteres'
                    ];
        
                    $validator = Validator::make($request->all(), $rules, $message);

                    if($validator->fails()){
                        return redirect()->route('password.user')->withErrors($validator);
                    }else{
                        if(Hash::check($request->mypassword, Auth::user()->password)){
                            $user = new User();
                            $user->where('email', '=' , Auth::user()->email)
                                 ->update(['password' => bcrypt($request->password)]);
                            return redirect()->route('detail.user',['id'=>$id] )->with('message', 'Contraseña cambiada con exito');
                        }else{
                            return redirect()->route('detail.user',['id'=>$id] )->with('message', 'Datos incorrectos');
                        }
                    }
    }

    public function detail($id){
        $user = User::find($id);
        $tickets = Ticket::where('status_ticket','Activa')->get();

        return view('user.userDetail', [
            'user'=>$user, 'tickets'=>$tickets
            ]);
    }

    public function delete(Request $request){

        $id = $request->input('id');

        $user = User::find($id);
        $user->delete();

        return redirect()->route('config');
    }
}
