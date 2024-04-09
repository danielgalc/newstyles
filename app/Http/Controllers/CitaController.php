<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cita = new Cita();
        $peluqueros = User::where('rol', 'empleado')->get();

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
        if ($user->isAdmin()) {
            $cita = new Cita([
                'user_id' => $request->input('user_id'),
                'peluquero_id' => $request->input('peluquero_id'),
                'fecha' => $request->input('fecha'),
                'hora' => $request->input('hora'),
                'servicio' => $request->input('servicio'),
                'estado' => 'aceptada',
            ]);

            $cita->save();

            return redirect('/admin/citas')->with('success', 'Cita añadida con éxito.');
        }

        $cita->save();

        return redirect('/admin/citas')->with('success', 'Cita añadida con éxito.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
