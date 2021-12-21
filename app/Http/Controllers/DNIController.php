<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Peru\Jne\DniFactory;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Str;

class DNIController extends Controller
{

    public function dniMultiple()
    {
        return view('dnimultiple');
    }

    public function dni()
    {
        return view('dni');
    }

    public function getDni($dni)
    {

        $client = new Client(['base_uri' => 'http://sdv.midis.gob.pe/', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'allow_redirects' => [
                'max' => 5
            ],
            'query' => [
                'iCodAplicacion' => 27,
                'iIdTipDocumento' => 1,
                'vNroDocumento' => $dni
            ]
        ];


        if (Str::length($dni) <= 8 ) {
            $factory = new DniFactory();
            $cs = $factory->create();
            $person = $cs->get($dni);

            $res = $client->request('POST', 'Sis_IDM_Admin/Persona/GetRENIEC', $parameters);
            $response = json_decode($res->getBody()->getContents(), true);

            if (!$person || !$response) {
                return response()->json(["error" => 404]);
            }
            return response()->json(['query1' => $person, 'query2' =>$response] );
        }

        else
        {
            return response()->json(["error" => 404]);
        }
    }
}
