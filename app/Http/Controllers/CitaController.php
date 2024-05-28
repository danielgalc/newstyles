<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $cita = new Cita();

        // Otros campos de la cita
        $cita->user_id = $request->input('user_id');
        $cita->peluquero_id = $request->input('peluquero_id');
        $cita->fecha = $request->input('fecha');
        $cita->hora = $request->input('hora');

        // Obtener el nombre del servicio desde la solicitud
        $servicio = $request->input('servicio');

        //dd($servicioId);

        // Asociar el nombre del servicio a la relación "servicio"
        $cita->servicio = $servicio;

        // Verifica si el usuario que crea la cita es un administrador
        $user = $request->user();
        if ($user->rol == 'admin') {
            $cita->servicio = Servicio::findOrFail($servicio)->nombre; // Asigna el nombre del servicio a la cita
            $cita->estado = 'aceptada';

            $cita->save();


            return redirect('/admin/citas')->with('success', 'Cita añadida con éxito.');
        }

        $cita->servicio = Servicio::findOrFail($servicio)->nombre; // Asigna el nombre del servicio a la cita

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
}
