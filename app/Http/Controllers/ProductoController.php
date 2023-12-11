<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
 
    public function index(Request $request)
    {
        $query = Producto::query();

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

        $productos = $query->paginate(8);

        return view('productos.index', [
            'productos' => $productos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $producto = new Producto();


        return view('productos.create', [
            'producto' => $producto,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $producto = new Producto();

    $producto->nombre = $request->input('nombre');
    $producto->descripcion = $request->input('descripcion');
    $producto->precio = $request->input('precio');
    $producto->imagen = $request->input('imagen'); // Si estás guardando el nombre del archivo, asegúrate de tener la lógica adecuada para manejar el archivo.
    $producto->stock = $request->input('stock');

    $producto->save();

    return redirect('/productos')
        ->with('success', 'Producto añadido con éxito.');
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
        $producto = Producto::findOrFail($id);

        return view('productos.edit', [
            'producto' => $producto,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::FindOrFail($id);

        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->imagen = $request->input('imagen'); 
        $producto->stock = $request->input('stock');

        $producto->save();

        return redirect('/productos')
            ->with('success', 'Producto modificado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::FindOrFail($id);

        $producto->delete();

        return redirect('/productos')
            ->with('success', 'Producto eliminado con éxito.');
    }
}
