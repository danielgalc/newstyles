<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carritos = Carrito::all();

        return view('carrito.index', [
            'carritos' => $carritos->where('user_id', Auth::user()->id)->sortBy('producto.nombre')
        ]);
    }

    public function completarCompra()
    {
        $user = Auth::user();
        $carritos = Carrito::where('user_id', $user->id)->get();

        if ($carritos->isEmpty()) {
            return redirect()->route('carrito')->with('error', '¡Tu carrito está vacío!');
        }

        $pedido = new Pedido();
        $pedido->user_id = $user->id;
        $pedido->dni = $user->dni;
        $pedido->telefono = $user->telefono;
        $pedido->direccion = $user->direccion;
        $pedido->precio_total = $carritos->sum(function ($carrito) {
            return $carrito->producto->precio * $carrito->cantidad;
        });
        $pedido->fecha_compra = now();
        $pedido->save();

        foreach ($carritos as $carrito) {
            $pedido->productos()->attach($carrito->producto_id, ['cantidad' => $carrito->cantidad]);
            $carrito->delete();
        }

        return redirect()->route('carrito')->with('success', 'Compra completada con éxito.');
    }

    public function add(Producto $producto)
    {
        $carrito = Carrito::where('producto_id', $producto->id)->where('user_id', auth()->user()->id)->first();

        if (empty($carrito)) {
            $carrito = new Carrito();
            $carrito->user_id = Auth::user()->id;
            $carrito->producto_id = $producto->id;
            $carrito->cantidad = 1;
        } else {
            $carrito->cantidad += 1;
        }

        $producto->stock -= 1;
        $producto->save();

        $carrito->save();

        return response()->json([
            'message' => 'Producto añadido al carrito.',
            'producto' => $producto
        ]);
    }

    public function clear()
    {
        $carritos = Carrito::where('user_id', auth()->user()->id)->get();

        foreach ($carritos as $carrito) {
            $producto = $carrito->producto;
            $producto->stock += $carrito->cantidad;
            $producto->save();
        }

        Carrito::where('user_id', auth()->user()->id)->delete();

        return redirect()->route('carrito')->with('success', 'Carrito vaciado con exito.');
    }


    public function decrementarCantidad(Carrito $carrito)
    {
        if ($carrito->cantidad === 1) {
            $carrito->producto->stock += 1;
            $carrito->producto->save();
            $carrito->delete();

            return redirect()->route('carrito')->with('success', 'Se eliminó el producto del carrito.');
        }

        $carrito->cantidad -= 1;
        $carrito->producto->stock += 1;
        $carrito->producto->save();
        $carrito->save();

        return redirect()->route('carrito')->with('success', 'Se redujo la cantidad del producto en el carrito.');
    }

    public function incrementarCantidad(Carrito $carrito)
    {
        if ($carrito->producto->stock > 0) {
            $carrito->cantidad += 1;
            $carrito->producto->stock -= 1;
            $carrito->producto->save();
            $carrito->save();

            return redirect()->route('carrito')->with('success', 'Se incrementó la cantidad del producto en el carrito.');
        } else {
            return redirect()->route('carrito')->with('error', 'No hay suficiente stock para añadir más de este producto.');
        }
    }
}
