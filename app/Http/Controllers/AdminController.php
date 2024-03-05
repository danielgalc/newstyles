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
    return view('admin.usuarios.usuarios', compact('usuarios'));
}

public function gestionarCitas()
{
    $citas = Cita::all();
    // Dando formato con Carbon
    $citas->each(function ($cita) {
        $cita->hora = \Carbon\Carbon::parse($cita->hora);
    });

    return view('admin.citas.gestionar_citas', compact('citas'));
}

public function listaServicios()
{
    $servicios = Servicio::all();
    return view('admin.servicios.lista_servicios', compact('servicios'));
}

public function listaProductos()
{
    $productos = Producto::all();
    return view('admin.productos.lista_productos', compact('productos'));
}

}
