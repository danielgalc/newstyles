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
    $usuarios = User::orderBy('updated_at', 'desc')->paginate(8); // Paginar con 8 usuarios por página
    return view('admin.usuarios.usuarios', compact('usuarios'));
}

public function gestionarCitas()
{
    $citas = Cita::paginate(5); 
    // Dando formato con Carbon
    $citas->each(function ($cita) {
        $cita->hora = \Carbon\Carbon::parse($cita->hora);
    });

    $servicios = Servicio::all();

    return view('admin.citas.gestionar_citas', compact('citas', 'servicios'));
}

public function listaServicios()
{
    $servicios = Servicio::orderBy('updated_at', 'desc')->paginate(8); 
    return view('admin.servicios.lista_servicios', compact('servicios'));
}

public function listaProductos()
{
    $productos = Producto::paginate(8);
    return view('admin.productos.lista_productos', compact('productos'));
}

public function mostrarDatos()
{
    $usuarios = User::latest()->take(5)->get();
    $citas = Cita::latest()->take(5)->get();
    $servicios = Servicio::latest()->take(5)->get();
    $productos = Producto::latest()->take(5)->get();
    
    $citas->each(function ($cita) {
        $cita->hora = \Carbon\Carbon::parse($cita->hora);});

    $citas->load('user', 'peluquero');


    return view('admin.admin', compact('usuarios', 'citas', 'servicios', 'productos'));
}

}
