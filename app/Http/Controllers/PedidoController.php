<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Mostrar la lista de pedidos
    public function index()
    {
        $pedidos = Pedido::withTrashed()->get(); // Incluye los pedidos eliminados
        return view('pedidos.index', compact('pedidos'));
    }

    // Mostrar el formulario para crear un nuevo pedido
    public function create()
    {
        return view('pedidos.create');
    }

    // Guardar un nuevo pedido
    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required|string',
            'precio_total' => 'required|numeric',
            'fecha_compra' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'dni' => 'required|string|size:9|unique:pedidos',
            'telefono' => 'required|string|size:9|unique:pedidos',
            'direccion' => 'required|string',
        ]);

        $pedido = new Pedido();
        $pedido->productos = $request->productos;
        $pedido->precio_total = $request->precio_total;
        $pedido->fecha_compra = $request->fecha_compra;
        $pedido->user_id = $request->user_id;
        $pedido->dni = $request->dni;
        $pedido->telefono = $request->telefono;
        $pedido->direccion = $request->direccion;
        $pedido->save();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido creado con éxito.');
    }

    // Mostrar un pedido específico
    public function show($id)
    {
        $pedido = Pedido::withTrashed()->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }

    // Mostrar el formulario para editar un pedido específico
    public function edit($id)
    {
        $pedido = Pedido::withTrashed()->findOrFail($id);
        return view('pedidos.edit', compact('pedido'));
    }

    // Actualizar un pedido específico
    public function update(Request $request, $id)
    {
        $pedido = Pedido::withTrashed()->findOrFail($id);

        $request->validate([
            'productos' => 'required|string',
            'precio_total' => 'required|numeric',
            'fecha_compra' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'dni' => 'required|string|size:9|unique:pedidos,dni,' . $pedido->id,
            'telefono' => 'required|string|size:9|unique:pedidos,telefono,' . $pedido->id,
            'direccion' => 'required|string',
        ]);

        $pedido->productos = $request->productos;
        $pedido->precio_total = $request->precio_total;
        $pedido->fecha_compra = $request->fecha_compra;
        $pedido->user_id = $request->user_id;
        $pedido->dni = $request->dni;
        $pedido->telefono = $request->telefono;
        $pedido->direccion = $request->direccion;
        $pedido->save();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido actualizado con éxito.');
    }

    // Eliminar un pedido específico (soft delete)
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido eliminado con éxito.');
    }

    // Restaurar un pedido específico
    public function restore($id)
    {
        $pedido = Pedido::withTrashed()->findOrFail($id);
        $pedido->restore();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido restaurado con éxito.');
    }

    // Eliminar permanentemente un pedido específico
    public function forceDelete($id)
    {
        $pedido = Pedido::withTrashed()->findOrFail($id);
        $pedido->forceDelete();

        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido eliminado permanentemente con éxito.');
    }
}
