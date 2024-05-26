<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

// ServicioController.php



public function index(Request $request)
{
    $serviciosPrincipales = Servicio::where('clase', 'principal')->get();
    $serviciosSecundarios = Servicio::where('clase', 'secundario')->get();

    $peluqueros = User::where('rol', 'empleado')->get();

    return Inertia::render('Servicios', [
        'serviciosPrincipales' => $serviciosPrincipales,
        'serviciosSecundarios' => $serviciosSecundarios,
        'peluqueros' => $peluqueros,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicio = new Servicio();


        return view('servicios.create', [
            'servicio' => $servicio,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $servicio = new Servicio();

        $servicio->nombre = $request->input('nombre');
        $servicio->precio = $request->input('precio');
        $servicio->duracion = $request->input('duracion');
        $servicio->clase = $request->input('clase');
    
        $servicio->save();
    
        return redirect('/admin/lista_servicios')
            ->with('success', 'Servicio añadido con éxito.');
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
        $servicio = Servicio::findOrFail($id);

        return view('servicios.edit', [
            'servicio' => $servicio,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $servicio = Servicio::FindOrFail($id);

        $servicio->nombre = $request->input('nombre');
        $servicio->precio = $request->input('precio');
        $servicio->duracion = $request->input('duracion');

        $servicio->save();

        return redirect('/admin/lista_servicios')
            ->with('success', 'servicio modificado con éxito.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::FindOrFail($id);

        $servicio->delete();

        return redirect('/admin/lista_servicios')
            ->with('success', 'Servicio eliminado con éxito.');
    }
}
