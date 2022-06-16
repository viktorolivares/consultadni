<?php

namespace App\Http\Controllers;

use App\Http\Services\ApiSunat;

class RucController extends Controller
{

        public function ruc()
    {
        return view('ruc');
    }

    public function getRuc($ruc)
    {

        $data = ApiSunat::search($ruc);
        return response()->json([
            'ruc' => $data,
        ]);
    }
}
