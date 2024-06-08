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
        $pedidos = Pedido::get(); // Incluye los pedidos eliminados
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
    
        // Obtener los pedidos paginados en orden de actualidad
        $pedidos = Pedido::where('user_id', $user->id)
            ->orderBy('fecha_compra', 'desc')
            ->paginate(10); // Pagina 10 pedidos por página
    
        // Obtener el pedido más reciente solo si estamos en la primera página
        $pedidoReciente = $pedidos->currentPage() == 1 ? $pedidos->first() : null;
    
        // Obtener los productos asociados a cada pedido desde pedido_producto
        foreach ($pedidos as $pedido) {
            $pedido->productos = DB::table('pedido_producto')
                ->where('pedido_id', $pedido->id)
                ->select('nombre_producto', 'cantidad')
                ->get()
                ->toArray();
        }
    
        return view('pedidos.historial_pedidos', [
            'pedidoReciente' => $pedidoReciente,
            'pedidos' => $pedidos
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
        $pedido = Pedido::findOrFail($id);
    
        // Obtener los productos asociados a este pedido desde pedido_producto
        $productos = DB::table('pedido_producto')
            ->where('pedido_id', $id)
            ->select('nombre_producto as nombre', 'cantidad')
            ->get();
    
        $pedido->productos = $productos;
    
        return response()->json($pedido);
    }
    

    public function descargarPDF($id)
    {
    // Encuentra el pedido por su ID
    $pedido = Pedido::findOrFail($id);

    if ($pedido->estado === 'cancelado') {
        return redirect()->back()->with('error', 'No se puede descargar el PDF de un pedido cancelado.');
    }

    // Obtén los productos asociados al pedido desde la tabla pivote pedido_producto
    $productos = DB::table('pedido_producto')
        ->where('pedido_id', $id)
        ->select('nombre_producto as nombre', 'cantidad')
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
        $pedido = Pedido::findOrFail($id);
        return view('pedidos.edit', compact('pedido'));
    }

    // Actualizar un pedido específico
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'estado' => 'required|string|in:pendiente,aceptado,enviado,cancelado',
        ]);

        $pedido->estado = $request->estado;
        $pedido->save();

        return redirect()->route('admin.pedidos')->with('success', 'Pedido actualizado con éxito.');
    }

    // Eliminar un pedido específico (soft delete)
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('admin.pedidos')
            ->with('success', 'Pedido eliminado con éxito.');
    }
}
