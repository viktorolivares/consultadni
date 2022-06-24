<?php

namespace App\Http\Services;

use Peru\Jne\DniFactory;

class Jne
{
    public static function search($dni)
    {
        if (strlen($dni) !== 8) {
            return [
                'success' => false,
                'message' => 'DNI debe contener 8 digitos.'
            ];
        }

        $factory = new DniFactory();
        $cs = $factory->create();

        $person = $cs->get($dni);
        if (!$person) {
            return (['error' => 404]);
        }

        return response()->json($person);
    }
}
