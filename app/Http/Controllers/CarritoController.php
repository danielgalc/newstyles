<?php

namespace App\Http\Controllers;

use App\Mail\CitaAceptada;
use App\Mail\PedidoRealizado;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::where('user_id', Auth::user()->id)->first();

        $carritos = $carrito ? $carrito->items : collect();
        $precioTotal = $carritos->sum(function ($item) {
            return $item->producto->precio * $item->cantidad;
        });

        return view('carrito.index', compact('carritos', 'precioTotal'));
    }

    public function migrar(Request $request)
    {
        $user = Auth::user();
        $productos = $request->input('productos', []);
    
        if ($user->rol === 'cliente') {
            Log::info('Productos recibidos para migrar:', $productos);
    
            if (!empty($productos)) {
                $carrito = Carrito::firstOrCreate(['user_id' => $user->id]);
    
                foreach ($productos as $item) {
                    $producto = Producto::find($item['producto_id']);
    
                    if ($producto) {
                        // Verificar si hay suficiente stock
                        if ($producto->stock < $item['cantidad']) {
                            return response()->json([
                                'error' => 'No hay suficiente stock disponible para migrar este producto: ' . $producto->nombre
                            ], 400);
                        }
    
                        $carritoItem = CarritoItem::where('carrito_id', $carrito->id)
                            ->where('producto_id', $item['producto_id'])
                            ->first();
    
                        if ($carritoItem) {
                            $carritoItem->cantidad += $item['cantidad'];
                            $carritoItem->save();
                        } else {
                            CarritoItem::create([
                                'carrito_id' => $carrito->id,
                                'producto_id' => $item['producto_id'],
                                'cantidad' => $item['cantidad'],
                            ]);
                        }
    
                        // Reducir el stock del producto
                        $producto->stock -= $item['cantidad'];
                        $producto->save();
                    }
                }
            }
    
            return response()->json(['message' => 'Carrito migrado con éxito.']);
        } else {
            return redirect('/');
        }
    }
    

    public function completarCompra(Request $request)
    {
        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return response()->json(['error' => '¡Tu carrito está vacío!'], 400);
        }

        $pedido = new Pedido();
        $pedido->user_id = $user->id;
        $pedido->dni = $user->dni;
        $pedido->telefono = $user->telefono;
        $pedido->direccion = $user->direccion;
        $pedido->precio_total = $carrito->items->sum(function ($item) {
            return $item->producto->precio * $item->cantidad;
        });
        $pedido->fecha_compra = Carbon::now()->format('d-m-Y');
        $pedido->transaccion = Pedido::generarTransaccion(); // Generar el valor de transacción
        $pedido->save();

        foreach ($carrito->items as $item) {
            // Obtener el nombre del producto
            $nombreProducto = $item->producto->nombre;

            // Adjuntar el producto al pedido con el nombre del producto
            $pedido->productos()->attach($item->producto_id, [
                'cantidad' => $item->cantidad,
                'nombre_producto' => $nombreProducto,
            ]);

            // Eliminar el item del carrito sin reponer el stock
            $item->delete();
        }

        Mail::to($user->email)->send(new PedidoRealizado($pedido));
        
        return response()->json(['success' => 'Compra completada con éxito.']);
    }




    public function add(Request $request, Producto $producto)
    {
        $cantidad = $request->input('cantidad', 1);

        // Verificar si hay suficiente stock
        if ($producto->stock < $cantidad) {
            return response()->json([
                'error' => 'No hay suficiente stock disponible para agregar este producto.'
            ], 400);
        }

        $carrito = Carrito::firstOrCreate(['user_id' => Auth::user()->id]);

        $carritoItem = CarritoItem::where('carrito_id', $carrito->id)
            ->where('producto_id', $producto->id)
            ->first();

        if (empty($carritoItem)) {
            $carritoItem = new CarritoItem();
            $carritoItem->carrito_id = $carrito->id;
            $carritoItem->producto_id = $producto->id;
            $carritoItem->cantidad = $cantidad;
        } else {
            // Verificar si hay suficiente stock para aumentar la cantidad
            if ($producto->stock < $carritoItem->cantidad + $cantidad) {
                return response()->json([
                    'error' => 'No hay suficiente stock disponible para agregar esta cantidad.'
                ], 400);
            }
            $carritoItem->cantidad += $cantidad;
        }

        $producto->stock -= $cantidad;
        $producto->save();

        $carritoItem->save();

        return response()->json([
            'message' => 'Producto añadido al carrito.',
            'producto' => $producto
        ]);
    }


    public function clear()
    {
        $carrito = Carrito::where('user_id', auth()->user()->id)->first();

        if ($carrito) {
            foreach ($carrito->items as $item) {
                // Reponer el stock del producto
                $producto = $item->producto;
                $producto->stock += $item->cantidad;
                $producto->save();

                // Eliminar el item del carrito
                $item->delete();
            }
        }

        return redirect()->route('carrito')->with('success', 'Carrito vaciado con éxito.');
    }


    public function decrementarCantidad(Request $request, $carritoItemId)
    {
        $carritoItem = CarritoItem::findOrFail($carritoItemId);
        $producto = $carritoItem->producto;

        if ($carritoItem->cantidad === 1) {
            $producto->stock += 1;
            $producto->save();
            $carritoItem->delete();

            return redirect()->route('carrito')->with('success', 'Se eliminó el producto del carrito.');
        }

        $carritoItem->cantidad -= 1;
        $producto->stock += 1;
        $producto->save();
        $carritoItem->save();

        return redirect()->route('carrito')->with('success', 'Se redujo la cantidad del producto en el carrito.');
    }

    public function incrementarCantidad(Request $request, $carritoItemId)
    {
        $carritoItem = CarritoItem::findOrFail($carritoItemId);
        $producto = $carritoItem->producto;

        // Verificar si hay suficiente stock
        if ($producto->stock > 0) {
            $carritoItem->cantidad += 1;
            $producto->stock -= 1;
            $producto->save();
            $carritoItem->save();

            return redirect()->route('carrito')->with('success', 'Se incrementó la cantidad del producto en el carrito.');
        } else {
            return redirect()->route('carrito')->with('error', 'No hay suficiente stock para añadir más de este producto.');
        }
    }
}
