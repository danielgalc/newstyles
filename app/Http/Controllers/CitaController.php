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
            'servicio' => $servicio
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
     
         // Obtener la ID del servicio desde la solicitud
         $servicioId = $request->input('servicio_id');
     
         // Asociar el ID del servicio a la relación "servicio"
         $cita->servicio = $servicioId;
     
         $cita->save();
     
         return redirect('/servicios')->with('success', 'Cita añadida con éxito.');
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
