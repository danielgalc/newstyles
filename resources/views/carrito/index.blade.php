<x-app-layout>
    <div class="container">
    <div class="row">
       <div class="col-sm-12 bg-light">
            <table class="table table-striped">
                <thead>
                    @if ($carritos->isEmpty())
                                <p>¡Tu carrito está vacío!</p>
                    @else
                    <th>Nombre del producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th class="px-6 py-2 text-gray-500">
                        <form action="{{route('clear')}}" method="post">
                            @csrf
                            @method('POST')
                            <button class="hover:bg-red-500 bg-red-300 text-black border px-7 py-2 rounded-xl" type="submit"> Vaciar carrito</button>
                        </form>
                    </th>
                </thead>
                <tbody>
                    @php
                        $precioTotal = 0;
                    @endphp
                    @foreach ($carritos as $carrito)
                    <tr>
                        <td class="px-6 py-2">{{ $carrito->producto->nombre }}</td>
                        
                        <td class="px-6 py-2">
                            <div class="text-sm text-gray-900 inline-block">
                                <form action="{{ route('decrementarCantidad', $carrito) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="px-4 py-1 text-sm border text-black mx-2 hover:bg-orange-500 rounded">-</button>
                                </form>
                            </div>
                            {{ $carrito->cantidad }}
                    
                            <div class="text-sm text-gray-900 inline-block">
                               <form action="{{ route('incrementarCantidad', $carrito) }}" method="POST">
                                   @csrf
                                   @method('POST')
                                   <button type="submit" class="px-4 py-1 border text-sm mx-2 text-black hover:bg-orange-500 rounded">+</button>
                               </form>
                            </div>
                        </td>
                        <td>
                            {{ $carrito->producto->precio * $carrito->cantidad}}&euro;
                        </td>
                    </tr>
                    @php
                        $precioTotal += $carrito->producto->precio * $carrito->cantidad 
                    @endphp
                    @endforeach

                </tbody>
                @endif
            </table>

            <div class="w-full flex justify-center w-1/4">
                <span class="text-xl  font-bold">Precio Total: </span>
                <span class="font-bold text-xl">{{$precioTotal}}&euro;</span>
            </div>
       </div>       
    </div>
</div>
</x-app-layout>
