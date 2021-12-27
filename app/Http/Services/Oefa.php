<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class Oefa
{
    public static function search($dni)
    {
        if (strlen($dni) !== 8) {
            return [
                'success' => false,
                'message' => 'DNI debe contener 8 digitos.'
            ];
        }

        $client = new Client(['base_uri' => 'https://sistemas.oefa.gob.pe/sirte-backend/comun/combo/SSOfindPersonaPorDni/', 'verify' => false]);

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
        ];

        $data = $client->request('GET', $dni);

        if (!$data) {
            return response()->json(["error" => 404]);
        }

        $response = json_decode($data->getBody()->getContents(), false);

        return response()->json($response);
    }
}
