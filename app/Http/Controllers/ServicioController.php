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
        $search = $request->input('search');
        $sortBy = $request->input('sortBy');


        // Construimos la query base para Servicio
        $query = Servicio::query();

        $peluqueros = User::where('rol', 'peluquero')->get();

        // Si hay una búsqueda, agregamos la condición a la query
        if ($search) {
            $query->where('nombre', 'ilike', "%{$search}%");
        }

        // Filtro orden
        switch ($sortBy) {
            case 'asc':
                $query->orderBy('nombre', 'asc');
                break;
            case 'desc':
                $query->orderBy('nombre', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('precio', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // Obtenemos todos los servicios que cumplen con la condición
        $servicios = $query->paginate(20);

        // Si el request espera una respuesta JSON
        if ($request->wantsJson()) {
            return response()->json($servicios);
        }

        // Si no, renderizamos la vista con Inertia
        return Inertia::render('Servicios/Servicios', [
            'servicios' => $servicios,
            'search' => $search,
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
        $request->validate([
            'nombre' => 'required|string|min:3|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'precio' => 'required|numeric|min:0.01',
            'duracion' => 'required|integer|min:15|max:60',
            'clase' => 'required|in:principal,secundario',
        ], [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.string' => 'El nombre del servicio debe ser una cadena de texto.',
            'nombre.min' => 'El nombre del servicio debe tener al menos 3 caracteres.',
            'nombre.regex' => 'El nombre del servicio no puede contener números ni símbolos especiales.',
            'precio.required' => 'El precio del servicio es obligatorio.',
            'precio.numeric' => 'El precio del servicio debe ser un número.',
            'precio.min' => 'El precio del servicio debe ser mayor que cero.',
            'duracion.required' => 'La duración del servicio es obligatoria.',
            'duracion.integer' => 'La duración del servicio debe ser un número entero.',
            'duracion.min' => 'La duración del servicio debe ser de al menos 15 minutos.',
            'duracion.max' => 'La duración del servicio no puede ser mayor a 60 minutos.',
            'clase.required' => 'La clase del servicio es obligatoria.',
            'clase.in' => 'La clase del servicio debe ser "principal" o "secundario".',
        ]);

        $servicio = new Servicio();

        $servicio->nombre = $request->input('nombre');
        $servicio->precio = $request->input('precio');
        $servicio->duracion = $request->input('duracion');
        $servicio->clase = $request->input('clase');

        $servicio->save();

        return redirect('/admin/servicios')
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
        $request->validate([
            'nombre' => 'required|string|min:3|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'precio' => 'required|numeric|min:0.01',
            'duracion' => 'required|integer|min:15|max:60',
            'clase' => 'required|in:principal,secundario',
        ], [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.string' => 'El nombre del servicio debe ser una cadena de texto.',
            'nombre.min' => 'El nombre del servicio debe tener al menos 3 caracteres.',
            'nombre.regex' => 'El nombre del servicio no puede contener números ni símbolos especiales.',
            'precio.required' => 'El precio del servicio es obligatorio.',
            'precio.numeric' => 'El precio del servicio debe ser un número.',
            'precio.min' => 'El precio del servicio debe ser mayor que cero.',
            'duracion.required' => 'La duración del servicio es obligatoria.',
            'duracion.integer' => 'La duración del servicio debe ser un número entero.',
            'duracion.min' => 'La duración del servicio debe ser de al menos 15 minutos.',
            'duracion.max' => 'La duración del servicio no puede ser mayor a 60 minutos.',
            'clase.required' => 'La clase del servicio es obligatoria.',
            'clase.in' => 'La clase del servicio debe ser "principal" o "secundario".',
        ]);

        $servicio = Servicio::findOrFail($id);

        $servicio->nombre = $request->input('nombre');
        $servicio->precio = $request->input('precio');
        $servicio->duracion = $request->input('duracion');
        $servicio->clase = $request->input('clase');

        $servicio->save();

        return redirect('/admin/servicios')
            ->with('success', 'Servicio modificado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::FindOrFail($id);

        $servicio->delete();

        return redirect('/admin/servicios')
            ->with('success', 'Servicio eliminado con éxito.');
    }
}
