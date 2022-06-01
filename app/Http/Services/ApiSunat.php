<?php

namespace App\Http\Services;

use Peru\Sunat\RucFactory;

class ApiSunat
{
    public static function search($ruc)
    {
        if (strlen($ruc) !== 11) {
            return [
                'success' => false,
                'message' => 'RUC debe contener 11 digitos.'
            ];
        }

        $factory = new RucFactory();
        $cs = $factory->create();

        $company = $cs->get($ruc);
        if (!$company) {
            return (['error' => 404]);
        }

        return response()->json($company);
    }
}
