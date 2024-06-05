<?php

namespace App\Http\Controllers;

use App\Models\BloqueoPeluquero;
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
        $buscar = $request->input('buscar'); // Obtener el término de búsqueda desde la solicitud

        $query = User::query();

        // Aplicar búsqueda si está presente
        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'LIKE', "%{$buscar}%")
                    ->orWhere('email', 'LIKE', "%{$buscar}%")
                    ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }

        // Aplicar filtro de rol si está presente
        if ($rol) {
            $query->where('rol', $rol);
        }

        $usuarios = $query->orderBy('updated_at', 'desc')->paginate(8);

        if ($request->ajax()) {
            return view('admin.usuarios.partials.usuarios_list', compact('usuarios'))->render();
        }

        return view('admin.usuarios.usuarios', compact('usuarios', 'rol', 'buscar'));
    }


    public function gestionarCitas(Request $request)
    {
        $estado = $request->input('estado'); // Obtener el filtro de estado desde la solicitud
        $buscar = $request->input('buscar'); // Obtener el término de búsqueda desde la solicitud
        $peluqueroId = $request->input('peluquero'); // Obtener el filtro de peluquero desde la solicitud
    
        $query = Cita::query();
    
        // Aplicar búsqueda si está presente
        if ($buscar) {
            $query->whereHas('user', function($q) use ($buscar) {
                $q->where('name', 'LIKE', "%{$buscar}%")
                  ->orWhere('email', 'LIKE', "%{$buscar}%")
                  ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }
    
        // Aplicar filtro de estado si está presente
        if ($estado) {
            $query->where('estado', $estado);
        }
    
        // Aplicar filtro de peluquero si está presente
        if ($peluqueroId) {
            $query->where('peluquero_id', $peluqueroId);
        }
    
        $citas = $query->orderBy('fecha', 'desc')->paginate(5);
        $servicios = Servicio::all();
        $users = User::where('rol', 'peluquero')->get();
    
        if ($request->ajax()) {
            return view('admin.citas.partials.citas_list', compact('citas'))->render();
        }
    
        return view('admin.citas.gestionar_citas', compact('citas', 'servicios', 'users', 'estado', 'buscar', 'peluqueroId'));
    }
    

    public function listaServicios(Request $request)
    {
        $clase = $request->input('clase'); // Obtener el filtro de clase desde la solicitud
        $buscar = $request->input('buscar'); // Obtener el término de búsqueda desde la solicitud

        $query = Servicio::query();

        // Aplicar filtro de clase si está presente
        if ($clase) {
            $query->where('clase', $clase);
        }

        // Aplicar búsqueda si está presente
        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }

        $servicios = $query->orderBy('updated_at', 'desc')->paginate(8);

        if ($request->ajax()) {
            return view('admin.servicios.partials.servicios_list', compact('servicios'))->render();
        }

        return view('admin.servicios.lista_servicios', compact('servicios', 'clase'));
    }

    public function listaProductos(Request $request)
    {
        $categoria = $request->input('categoria'); // Obtener el filtro de categoría desde la solicitud
        $buscar = $request->input('buscar'); // Obtener el término de búsqueda desde la solicitud

        $query = Producto::query();

        // Aplicar filtro de categoría si está presente
        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        // Aplicar búsqueda si está presente
        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        $productos = $query->orderBy('updated_at', 'desc')->paginate(8);

        if ($request->ajax()) {
            return view('admin.productos.partials.productos_list', compact('productos'))->render();
        }

        return view('admin.productos.lista_productos', compact('productos', 'categoria', 'buscar'));
    }

    public function gestionarBloqueos(Request $request)
    {
        $bloqueos = BloqueoPeluquero::with('peluquero')->paginate(5);
        $users = User::where('rol', 'peluquero')->get();

        foreach ($bloqueos as $bloqueo) {
            $bloqueo->horas = json_decode($bloqueo->horas, true);
        }

        return view('admin.bloqueos.bloqueos', compact('bloqueos', 'users'));
    }

    public function mostrarDatos()
    {
        $usuarios = User::latest()->take(5)->get();
        $citas = Cita::latest()->take(5)->get();
        $servicios = Servicio::latest()->take(5)->get();
        $productos = Producto::latest()->take(5)->get();
        $bloqueos = BloqueoPeluquero::with('peluquero')->latest()->take(5)->get();

        $citas->each(function ($cita) {
            $cita->hora = \Carbon\Carbon::parse($cita->hora);
        });

        $citas->load('user', 'peluquero');

        $bloqueos->each(function ($bloqueo) {
            $bloqueo->horas = collect(json_decode($bloqueo->horas))->map(function ($hora) {
                return \Carbon\Carbon::createFromFormat('H:i:s', $hora)->format('H:i');
            })->toArray();
        });

        return Inertia::render('Admin/Admin', [
            'usuarios' => $usuarios,
            'citas' => $citas,
            'servicios' => $servicios,
            'productos' => $productos,
            'bloqueos' => $bloqueos,
        ]);
    }
}
