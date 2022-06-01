<?php

namespace App\Http\Controllers;

use App\Http\Services\Midis;
use App\Http\Services\Oefa;
use App\Http\Services\Sunat;


class DniController extends Controller
{

    public function dniMultiple()
    {
        return view('dnimultiple');
    }

    public function dni()
    {
        return view('dni');
    }

    public function services()
    {
        return view('services');
    }

    public function age()
    {
        return view('age');
    }

    public function getDni($dni)
    {
        $midis = Midis::search($dni);
        $oefa = Oefa::search($dni);
        $sunat = Sunat::search($dni);

        $verifyCode = $this->getVerifyCode($dni);

        return response()->json([
            'codigoV' => $verifyCode,
            'midis' => $midis,
            'oefa' => $oefa,
            'sunat' => $sunat,
        ]);
    }

    private function getVerifyCode($dni)
    {
        if (is_numeric($dni)) {
            $suma = 5;
            $len = strlen($dni);
            $hash = [3, 2, 7, 6, 5, 4, 3, 2];

            for ($i = 0; $i < $len; ++$i) {
                $suma += $dni[$i] * $hash[$i];
            }

            $entero = (int) ($suma / 11);
            $digito = 11 - ($suma - $entero * 11);

            return $digito > 9 ? $digito - 10 : $digito;
        } else {
            return response()->json("No es númerico");
        }

    }

}
