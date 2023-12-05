<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
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

    public function add(Producto $producto)
    {
        $carrito = Carrito::where('producto_id', $producto->id)->where('user_id', auth()->user()->id)->first();

        if (empty($carrito)) {

            $carrito = new Carrito();

            $carrito->user_id = Auth::user()->id;
            $carrito->producto_id = $producto->id;
            $carrito->cantidad = 1;

            $carrito->save();

            return redirect()->route('productos')->with('success', 'Producto añadido al carrito.');
        }

        $carrito->cantidad += 1;
        $carrito->save();

        return redirect()->route('productos')->with('success', 'Producto anadido al carrito.');
    }

    public function clear()
    {
        $carrito = Carrito::where('user_id', auth()->user()->id);
        $carrito->delete();

        return redirect()->route('carrito')->with('success', 'Carrito vaciado con exito.');
    }

    public function decrementarCantidad(Carrito $carrito)
    {
        if ($carrito->cantidad === 1) {
            $carrito->delete();
    
            return redirect()->route('carrito')->with('success', 'Se eliminó el producto del carrito.');
        }
    
        $carrito->cantidad -= 1;
        $carrito->save();
    
        return redirect()->route('carrito')->with('success', 'Se redujo la cantidad del producto en el carrito.');
    }
    
    public function incrementarCantidad(Carrito $carrito)
    {
        $carrito->cantidad += 1;
        $carrito->save();
    
        return redirect()->route('carrito')->with('success', 'Se incrementó la cantidad del producto en el carrito.');
    }    
}
