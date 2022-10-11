<?php

namespace App\Http\Controllers;
$cliente= "App\Client";

use Illuminate\Http\Request;
use App\Client as Cliente;
use GuzzleHttp\Client;
use App\Ticket;

class ClientController extends Controller
{
    public function save(Request $request)
    {

        $client = new Cliente();
        $ci     = $request->input('ci');

        $search = $client->all()->where('ci_client', $ci)->first();
        // var_dump($search);
        // die();

        if ($search == null) {

            $validate = $this->validate($request, ['ci' => 'required|min:6|max:9']);

            $client = new Cliente();
            $client->ci_client = $ci;
            $client->save();

            $search = $client->all()->where('ci_client', $ci)->first();

            //return redirect()->route('index.turn',['ci' => $search2->id])->with(['message'=>'Bienvenido ¡Eres nuevo entrando al sistema! - Selecciona una taquilla para continuar con el servicio.']);

        }
        $tickets = Ticket::orderBy('name_ticket', 'asc')->get();

        //validar dni
        $numero = $ci;
        $token = 'apis-token-2932.HLOdQh3sd62JwzoN62gnbgExmmwmiFH6';
        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-dni',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $numero]
        ];
        $res = $client->request('GET', '/v1/dni', $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        /*return response()->json(array(
            'response' => $response
        ));*/

        return view('turn.turnSelect', [
            'ci'     => $search->id,
            'tickets' => $tickets,
            'response' => $response,
        ]);
    }
}
