<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class ExternalApi
{
    public static function search($dni)
    {
        if (strlen($dni) !== 8) {
            return [
                'success' => false,
                'message' => 'DNI debe contener 8 digitos.'
            ];
        }

        $client = new Client(['base_uri' => 'https://www.facturacionelectronica.us/', 'verify' => false]);

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
                'documento' => "DNI",
                'usuario' => "10447915125",
                'password' => "985511933",
                'nro_documento' => $dni
            ]
        ];

        $data = $client->request('POST', 'facturacion/controller/ws_consulta_rucdni_v2.php', $parameters);

        if (!$data) {
            return response()->json(["error" => 404]);
        }

        $response = json_decode($data->getBody()->getContents(), true);

        return response()->json($response);
    }
}
