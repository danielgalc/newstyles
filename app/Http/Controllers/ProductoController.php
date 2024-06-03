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
        // Validar los datos de entrada
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/'],
            'descripcion' => ['required', 'string', 'min:5'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'imagen' => ['nullable', 'max:2048'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria' => ['required', 'string'],
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre del producto debe ser una cadena de texto.',
            'nombre.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'nombre.regex' => 'El nombre del producto solo puede contener letras y espacios.',
            'descripcion.required' => 'La descripción del producto es obligatoria.',
            'descripcion.string' => 'La descripción del producto debe ser una cadena de texto.',
            'descripcion.min' => 'La descripción del producto debe tener al menos 5 caracteres.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio del producto debe ser un número.',
            'precio.min' => 'El precio del producto debe ser mayor que cero.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpeg, png, jpg, gif, svg.',
            'imagen.max' => 'La imagen no debe ser mayor a 2048 kilobytes.',
            'stock.required' => 'El stock del producto es obligatorio.',
            'stock.integer' => 'El stock del producto debe ser un número entero.',
            'stock.min' => 'El stock del producto no puede ser negativo.',
            'categoria.required' => 'La categoría del producto es obligatoria.',
            'categoria.string' => 'La categoría del producto debe ser una cadena de texto.',
        ]);
    
        $producto = new Producto();
    
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->imagen = $request->input('imagen');
        $producto->stock = $request->input('stock');
        $producto->categoria = $request->input('categoria');
    
        $producto->save();
    
        return redirect('/admin/productos')
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
        $producto = Producto::findOrFail($id);
    
        // Validar los datos de entrada
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/'],
            'descripcion' => ['required', 'string', 'min:5'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'imagen' => ['nullable', 'max:2048'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria' => ['required', 'string'],
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre del producto debe ser una cadena de texto.',
            'nombre.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'nombre.regex' => 'El nombre del producto solo puede contener letras y espacios.',
            'descripcion.required' => 'La descripción del producto es obligatoria.',
            'descripcion.string' => 'La descripción del producto debe ser una cadena de texto.',
            'descripcion.min' => 'La descripción del producto debe tener al menos 5 caracteres.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio del producto debe ser un número.',
            'precio.min' => 'El precio del producto debe ser mayor que cero.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpeg, png, jpg, gif, svg.',
            'imagen.max' => 'La imagen no debe ser mayor a 2048 kilobytes.',
            'stock.required' => 'El stock del producto es obligatorio.',
            'stock.integer' => 'El stock del producto debe ser un número entero.',
            'stock.min' => 'El stock del producto no puede ser negativo.',
            'categoria.required' => 'La categoría del producto es obligatoria.',
            'categoria.string' => 'La categoría del producto debe ser una cadena de texto.',
        ]);
    
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

        return redirect('/admin/productos')
            ->with('success', 'Producto eliminado con éxito.');
    }
}
