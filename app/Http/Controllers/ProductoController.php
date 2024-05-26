<?php

namespace App\Http\Controllers;


use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Producto::query();

        if ($search) {
            $query->where('nombre', 'ilike', "%{$search}%")
                  ->orWhere('descripcion', 'ilike', "%{$search}%");
        }

        $productos = $query->paginate(8);

        if ($request->wantsJson()) {
            return response()->json([
                'productos' => $productos,
            ]);
        }

        return Inertia::render('Productos/Productos', [
            'productos' => $productos,
            'search' => $search,
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
        $producto->imagen = $request->input('imagen');
        $producto->stock = $request->input('stock');

        $producto->save();

        return redirect('/admin/lista_productos')
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

        return redirect('/admin/lista_productos')
            ->with('success', 'Producto modificado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::FindOrFail($id);

        $producto->delete();

        return redirect('/admin/lista_productos')
            ->with('success', 'Producto eliminado con éxito.');
    }
}
