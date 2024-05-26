<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

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


        $servicios = Servicio::all();
        $users = User::where('rol', 'peluquero')->get();
        /* dd($users); */

        return view('admin.citas.gestionar_citas', compact('citas', 'servicios', 'users'));
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
            $cita->hora = \Carbon\Carbon::parse($cita->hora);
        });
    
        $citas->load('user', 'peluquero');
    
        return Inertia::render('Admin/Admin', [
            'usuarios' => $usuarios,
            'citas' => $citas,
            'servicios' => $servicios,
            'productos' => $productos,
        ]);
    }
}
