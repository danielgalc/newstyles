<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::all();

        return view('citas.index', [
            'citas' => $citas,
        ]);
    }

    public function historial()
    {
        // Obtiene el usuario actualmente autenticado
        $user = auth()->user();

        // Obtiene la próxima cita activa (aceptada o pendiente)
        $proximaCitaActiva = Cita::where('user_id', $user->id)
            ->whereIn('estado', ['aceptada', 'pendiente'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->first();

        // Si no hay citas activas, obtiene la próxima cita inactiva (cancelada)
        $proximaCitaInactiva = null;
        if (!$proximaCitaActiva) {
            $proximaCitaInactiva = Cita::where('user_id', $user->id)
                ->where('estado', 'cancelada')
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                ->first();
        }

        // Obtiene todas las citas finalizadas o canceladas, ordenadas de más recientes a más antiguas
        $citasFinalizadas = Cita::where('user_id', $user->id)
            ->whereIn('estado', ['finalizada', 'cancelada'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        // Obtiene todos los peluqueros
        $users = User::where('rol', 'peluquero')->get();

        return view('citas.historial-citas', [
            'proximaCita' => $proximaCitaActiva ? $proximaCitaActiva : $proximaCitaInactiva,
            'citasFinalizadas' => $citasFinalizadas,
            'users' => $users,
        ]);
    }

    public function cancelar(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'cancelada';
        $cita->save();

        return redirect()->route('historial-citas')->with('success', 'Cita cancelada con éxito.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cita = new Cita();
        $peluqueros = User::where('rol', 'peluquero')->get();

        $servicios = Servicio::all();

        // Obtener la ID de la URL
        $servicioId = $request->route('id');

        // Buscar el servicio por ID
        $servicio = $servicios->find($servicioId);

        return view('citas.create', [
            'cita' => $cita,
            'peluqueros' => $peluqueros,
            'servicio' => $servicio,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'peluquero_id' => 'required|exists:users,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'servicio' => 'required|exists:servicios,id',
        ], [
            'user_id.required' => 'El campo ID Cliente es obligatorio.',
            'user_id.exists' => 'El cliente seleccionado no es válido.',
            'peluquero_id.required' => 'El campo Peluquero es obligatorio.',
            'peluquero_id.exists' => 'El peluquero seleccionado no es válido.',
            'fecha.required' => 'El campo Fecha es obligatorio.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'hora.required' => 'El campo Hora es obligatorio.',
            'hora.date_format' => 'La hora no es válida.',
            'servicio.required' => 'El campo Servicio es obligatorio.',
            'servicio.exists' => 'El servicio seleccionado no es válido.',
        ]);

        // Crear una nueva instancia de Cita
        $cita = new Cita();
        $cita->user_id = $validatedData['user_id'];
        $cita->peluquero_id = $validatedData['peluquero_id'];
        $cita->fecha = $validatedData['fecha'];
        $cita->hora = $validatedData['hora'];

        // Asociar el nombre del servicio a la relación "servicio"
        $servicio = Servicio::findOrFail($validatedData['servicio']);
        $cita->servicio = $servicio->nombre;

        // Verifica si el usuario que crea la cita es un administrador
        $user = $request->user();
        if ($user->rol == 'admin') {
            $cita->estado = 'aceptada';
            $cita->save();

            return redirect('/admin/citas')->with('success', 'Cita añadida con éxito.');
        }

        $cita->save();

        return redirect('/historial-citas')->with('success', 'Cita añadida con éxito.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Cita::findOrFail($id);

        return view('citas.edit', [
            'cita' => $cita,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cita = Cita::FindOrFail($id);

        // Obtener el nombre del servicio desde la solicitud
        $servicio = $request->input('servicio');

        $cita->user_id = $request->input('user_id');
        $cita->peluquero_id = $request->input('peluquero_id');
        $cita->servicio = Servicio::findOrFail($servicio)->nombre; // Asigna el nombre del servicio a la cita

        $cita->fecha = $request->input('fecha');
        $cita->hora = $request->input('hora');
        $cita->estado = $request->input('estado');

        $cita->save();

        return redirect('/admin/citas')
            ->with('success', 'Cita modificada con éxito.');
    }

    public function updateFromHistorial(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        $newData = [
            'peluquero_id' => $request->input('peluquero_id'),
            'fecha' => $request->input('fecha'),
            'hora' => $request->input('hora'),
        ];

        $cita->peluquero_id = $newData['peluquero_id'];
        $cita->fecha = $newData['fecha'];
        $cita->hora = $newData['hora'];
        $cita->estado = 'pendiente';

        $cita->save();

        return redirect()->route('historial-citas')->with('success', 'Cita modificada con éxito.');
    }

    public function buscarUsuarios(Request $request)
    {
        $query = $request->get('query');
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->orderBy('id')
            ->get(['id', 'name']);

        return response()->json($users);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::FindOrFail($id);

        $cita->delete();

        return redirect('/admin/citas')
            ->with('success', 'Cita eliminada con éxito.');
    }

    public function actualizar_estado(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        // Actualiza solo el estado de la cita
        $cita->estado = $request->input('estado');

        $cita->save();

        return redirect()->back()->with('success', 'Estado de la cita actualizado con éxito.');
    }

    /**
     * Funciones del usuario peluquero
     */

    public function obtenerCitas(Request $request): JsonResponse
    {
        $peluqueroId = $request->query('peluquero_id');
        $citas = Cita::where('peluquero_id', $peluqueroId)
            ->where('estado', 'aceptada')
            ->get();

        return response()->json($citas);
    }

    public function gestionarCitas()
    {
        $user = Auth::user();

        if ($user->rol != 'peluquero' || !str_ends_with($user->email, '@peluquero.com')) {
            return redirect()->route('home');
        }

        $citasPendientes = Cita::where('peluquero_id', $user->id)->where('estado', 'pendiente')->get();
        $citasAceptadas = Cita::where('peluquero_id', $user->id)->where('estado', 'aceptada')->get();

        // Debugging
        // dd($citasPendientes, $citasAceptadas);

        return view('peluquero.citas', compact('citasPendientes', 'citasAceptadas'));
    }


    public function aceptarCita($id)
    {
        $cita = Cita::find($id);
        $peluqueroId = Auth::id();

        if ($cita->peluquero_id != $peluqueroId || $cita->estado != 'pendiente') {
            return redirect()->back();
        }

        DB::transaction(function () use ($cita, $peluqueroId) {
            Cita::where('peluquero_id', $peluqueroId)
                ->where('fecha', $cita->fecha)
                ->where('hora', $cita->hora)
                ->where('estado', 'pendiente')
                ->update(['estado' => 'cancelada']);

            $cita->estado = 'aceptada';
            $cita->save();
        });

        return redirect()->route('peluquero.citas');
    }

    public function cancelarCita($id)
    {
        $cita = Cita::find($id);
        $peluqueroId = Auth::id();

        if ($cita->peluquero_id != $peluqueroId || ($cita->estado != 'pendiente' && $cita->estado != 'aceptada')) {
            return redirect()->back();
        }

        $cita->estado = 'cancelada';
        $cita->save();

        return redirect()->route('peluquero.citas');
    }
}
