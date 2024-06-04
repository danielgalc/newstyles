<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloqueoPeluquero;

class BloqueoPeluqueroController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->user_id;

        $horas = array_map(function($hora) {
            return $hora . ':00';
        }, $request->horas);

        BloqueoPeluquero::create([
            'peluquero_id' => $userId,
            'fecha' => $request->fecha,
            'horas' => $horas,
        ]);

        return back()->with('success', 'Bloqueo creado con éxito.');
    }
}

