<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::where('user_id', Auth::user()->id)->first();
    
        $carritos = $carrito ? $carrito->items : collect();
    
        return view('carrito.index', compact('carritos'));
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
                }
            }

            return response()->json(['message' => 'Carrito migrado con éxito.']);
        } else {
            return redirect('/');
        }
    }

    public function completarCompra()
    {
        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return redirect()->route('carrito')->with('error', '¡Tu carrito está vacío!');
        }

        $pedido = new Pedido();
        $pedido->user_id = $user->id;
        $pedido->dni = $user->dni;
        $pedido->telefono = $user->telefono;
        $pedido->direccion = $user->direccion;
        $pedido->precio_total = $carrito->items->sum(function ($item) {
            return $item->producto->precio * $item->cantidad;
        });
        $pedido->fecha_compra = now();
        $pedido->save();

        foreach ($carrito->items as $item) {
            $pedido->productos()->attach($item->producto_id, ['cantidad' => $item->cantidad]);
            $item->delete();
        }

        return redirect()->route('carrito')->with('success', 'Compra completada con éxito.');
    }

    public function add(Request $request, Producto $producto)
    {
        $cantidad = $request->input('cantidad', 1);

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
                $producto = $item->producto;
                $producto->stock += $item->cantidad;
                $producto->save();
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
