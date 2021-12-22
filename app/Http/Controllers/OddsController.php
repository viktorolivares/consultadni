<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
Use GuzzleHttp\Client;
use Carbon\Carbon;
use Str;

class OddsController extends Controller
{

    public function index()
    {
        return view('odds');
    }

    public function odds()
    {
        $client = new Client(['base_uri' => 'https://live-api.teapuesto.pe/', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', 'api/v2/live/check');

        $response = json_decode($res->getBody()->getContents(), false);

        return response()->json($response);

    }

}
