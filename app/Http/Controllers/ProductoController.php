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
        $sortBy = $request->input('sortBy');
        $category = $request->input('category');

        $query = Producto::query();

        if ($search) {
            $query->where('nombre', 'ilike', "%{$search}%")
                ->orWhere('descripcion', 'ilike', "%{$search}%");
        }

        if ($category) {
            $query->where('categoria', $category);
        }

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

        $productos = $query->paginate(8);

        if ($request->wantsJson()) {
            return response()->json([
                'productos' => $productos,
            ]);
        }

        return Inertia::render('Productos/Productos', [
            'productos' => $productos,
            'search' => $search,
            'sortBy' => $sortBy,
            'category' => $category,
        ]);
    }

    public function categorias()
    {
        $categorias = Producto::select('categoria')
            ->distinct()
            ->whereNotNull('categoria')
            ->pluck('categoria');

        return response()->json($categorias);
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
        $producto->categoria = $request->input('categoria');

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
        $producto->categoria = $request->input('categoria');

        $producto->save();

        return redirect('/admin/productos')
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
