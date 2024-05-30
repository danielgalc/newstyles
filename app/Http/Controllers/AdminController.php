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
    public function usuarios(Request $request)
    {
        $rol = $request->input('rol'); // Obtener el filtro de rol desde la solicitud

        // Aplicar filtro de rol si está presente
        if ($rol) {
            $usuarios = User::where('rol', $rol)->orderBy('updated_at', 'desc')->paginate(8);
        } else {
            $usuarios = User::orderBy('updated_at', 'desc')->paginate(8);
        }

        if ($request->ajax()) {
            return view('admin.usuarios.partials.usuarios_list', compact('usuarios'))->render();
        }

        return view('admin.usuarios.usuarios', compact('usuarios', 'rol'));
    }

    public function gestionarCitas(Request $request)
    {
        $estado = $request->input('estado'); // Obtener el filtro de estado desde la solicitud

        // Aplicar filtro de estado si está presente
        if ($estado) {
            $citas = Cita::where('estado', $estado)->orderBy('fecha', 'desc')->paginate(5);
        } else {
            $citas = Cita::orderBy('fecha', 'desc')->paginate(5);
        }

        $servicios = Servicio::all();
        $users = User::where('rol', 'peluquero')->get();

        return view('admin.citas.gestionar_citas', compact('citas', 'servicios', 'users', 'estado'));
    }

    public function listaServicios(Request $request)
    {
        $clase = $request->input('clase');
    
        // Aplicar filtro de clase si está presente
        if ($clase) {
            $servicios = Servicio::where('clase', $clase)->orderBy('updated_at', 'desc')->paginate(8);
        } else {
            $servicios = Servicio::orderBy('updated_at', 'desc')->paginate(8);
        }
    
        if ($request->ajax()) {
            return view('admin.servicios.partials.servicios_list', compact('servicios'))->render();
        }
    
        return view('admin.servicios.lista_servicios', compact('servicios', 'clase'));
    }

    public function listaProductos(Request $request)
    {
        $categoria = $request->input('categoria'); // Obtener el filtro de categoría desde la solicitud
    
        // Aplicar filtro de categoria si está presente
        if ($categoria) {
            $productos = Producto::where('categoria', $categoria)->orderBy('updated_at', 'desc')->paginate(8);
        } else {
            $productos = Producto::orderBy('updated_at', 'desc')->paginate(8);
        }
    
        if ($request->ajax()) {
            return view('admin.productos.partials.productos_list', compact('productos'))->render();
        }
    
        return view('admin.productos.lista_productos', compact('productos', 'categoria'));
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
