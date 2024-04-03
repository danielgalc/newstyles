<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Servicio::query();

        $peluqueros = User::where('rol', 'empleado')->get();

        if ($request->has('ordenar')) {
            $ordenar = $request->input('ordenar');
            if ($ordenar == 'nombre_asc') {
                $query->orderBy('nombre', 'asc');
            } elseif ($ordenar == 'nombre_desc') {
                $query->orderBy('nombre', 'desc');
            } elseif ($ordenar == 'precio_asc') {
                $query->orderBy('precio', 'asc');
            } elseif ($ordenar == 'precio_desc') {
                $query->orderBy('precio', 'desc');
            }
        }

        if ($request->has('buscar')) {
            $buscar = $request->input('buscar');
            $query->where('nombre', 'like', '%' . $buscar . '%');
        }

        $servicios = $query->get()->where('clase', 'secundario');

        $serviciosPrincipales = $query->get()->where("clase", "principal");
        $serviciosSecundarios = $query->get()->where("clase", "secundario");


        return view('servicios.index', [
            'servicios' => $servicios,
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
