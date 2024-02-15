<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Producto;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function usuarios()
{
    $usuarios = User::all();
    return view('admin.usuarios', compact('usuarios'));
}

public function gestionarCitas()
{
    $citas = Cita::all();
    // Dando formato con Carbon
    $citas->each(function ($cita) {
        $cita->hora = \Carbon\Carbon::parse($cita->hora);
    });

    return view('admin.gestionar_citas', compact('citas'));
}

public function listaServicios()
{
    // Lógica para obtener y retornar la vista de lista de servicios
}

public function listaProductos()
{
    // Lógica para obtener y retornar la vista de lista de productos
}

}
