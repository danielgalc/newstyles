<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'transaccion' => 'nullable|string|unique:pedidos',
        ]);

        $pedido = new Pedido();
        $pedido->productos = $request->productos;
        $pedido->precio_total = $request->precio_total;
        $pedido->fecha_compra = $request->fecha_compra;
        $pedido->user_id = $request->user_id;
        $pedido->dni = $request->dni;
        $pedido->telefono = $request->telefono;
        $pedido->direccion = $request->direccion;
        $pedido->estado = 'pagado';
        $pedido->transaccion = $request->transaccion;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado con éxito.');
    }

    public function historial()
    {
        $user = Auth::user();

        // Obtener los pedidos en orden de actualidad
        $pedidos = Pedido::where('user_id', $user->id)
            ->orderBy('fecha_compra', 'desc')
            ->get();

        $pedidoReciente = $pedidos->first();
        $pedidosAnteriores = $pedidos->skip(1); // Omitir el más reciente para mostrar los anteriores por separado

        return view('pedidos.historial_pedidos', [
            'pedidoReciente' => $pedidoReciente,
            'pedidosAnteriores' => $pedidosAnteriores
        ]);
    }


    public function cancelarPedido($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $user = Auth::user();
        $now = \Carbon\Carbon::now();

        // Verificar si el pedido puede ser cancelado
        if ($pedido->estado === 'Enviado') {
            return response()->json(['error' => 'No se puede cancelar un pedido que ya ha sido enviado.'], 400);
        }

        if ($pedido->estado === 'Cancelado') {
            return response()->json(['error' => 'El pedido ya está cancelado.'], 400);
        }

        $fechaCompra = \Carbon\Carbon::parse($pedido->fecha_compra);
        $diffInHours = $fechaCompra->diffInHours($now);

        if ($diffInHours > 48) {
            return response()->json(['error' => 'No se puede cancelar un pedido después de 48 horas desde su compra.'], 400);
        }

        // Actualizar el estado del pedido a cancelado
        $pedido->estado = 'Cancelado';
        $pedido->save();

        return response()->json(['success' => 'Pedido cancelado con éxito.']);
    }

    // Mostrar un pedido específico
    public function show($id)
    {
        $pedido = Pedido::with('productos')->findOrFail($id);
        return response()->json($pedido);
    }

    public function descargarPDF($id)
    {
        // Encuentra el pedido por su ID
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado === 'cancelado') {
            return redirect()->back()->with('error', 'No se puede descargar el PDF de un pedido cancelado.');
        }

        // Obtén los productos asociados al pedido desde la tabla pivote
        $productos = DB::table('pedido_producto')
            ->join('productos', 'pedido_producto.producto_id', '=', 'productos.id')
            ->where('pedido_producto.pedido_id', $id)
            ->select('productos.nombre', 'pedido_producto.cantidad')
            ->get();

        $pdf = FacadePdf::loadView('pedidos.pdf', [
            'pedido' => $pedido,
            'productos' => $productos,
        ]);

        return $pdf->stream("pedido_{$id}.pdf");
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
            'transaccion' => 'nullable|string|unique:pedidos,transaccion,' . $pedido->id, // Validación para transacción
        ]);

        $pedido->productos = $request->productos;
        $pedido->precio_total = $request->precio_total;
        $pedido->fecha_compra = $request->fecha_compra;
        $pedido->user_id = $request->user_id;
        $pedido->dni = $request->dni;
        $pedido->telefono = $request->telefono;
        $pedido->direccion = $request->direccion;
        $pedido->estado = $request->estado;
        $pedido->transaccion = $request->transaccion;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado con éxito.');
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
