<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class Midis
{
    public static function search($dni)
    {
        if (strlen($dni) !== 8) {
            return [
                'success' => false,
                'message' => 'DNI debe contener 8 digitos.'
            ];
        }

        $client = new Client(['base_uri' => 'http://sdv.midis.gob.pe/', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => [
                'iCodAplicacion' => 27,
                'iIdTipDocumento' => 1,
                'vNroDocumento' => $dni
            ]
        ];

        $data = $client->request('POST', 'Sis_IDM_Admin/Persona/GetRENIEC', $parameters);

        if (!$data) {
            return response()->json(["error" => 404]);
        }

        $response = json_decode($data->getBody()->getContents(), true);

        return response()->json($response);
    }
}
