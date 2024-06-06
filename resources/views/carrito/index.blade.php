<x-app-layout>
    <div class="container mx-auto mt-4">
        <div class="flex flex-col items-center">
            @if (session()->has('error'))
                <div class="bg-red-100 rounded-lg p-4 mt-4 mb-4 text-sm text-red-700" role="alert">
                    <span class="font-semibold">Error:</span>
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="bg-green-100 rounded-lg p-4 mt-4 mb-4 text-sm text-green-700" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="container flex">
                @if ($carritos->isEmpty())
                    <div class="flex flex-col gap-8 mt-56 p-4 mb-4 mx-auto justify-center items-center">
                        <p class="text-center mx-auto text-6xl font-semibold mt-4">¡Tu carrito está vacío!</p>
                        <a href="/productos" class="font-righteous text-4xl text-teal-500">Haz click aquí para empezar a comprar</a>
                    </div>
                @else
                    <div class="w-2/3">
                        <div class="grid grid-cols-1 gap-4">
                            @php
                                $precioTotal = 0;
                            @endphp
                            @foreach ($carritos as $carrito)
                                <div class="flex bg-white rounded-md shadow-md p-4 mb-4 items-center">
                                    <img src="/images/productos/{{ $carrito->producto->imagen }}" alt="{{ $carrito->producto->nombre }}" class="w-24 h-24 object-cover rounded-md">
                                    <div class="flex-1 ml-4">
                                        <h3 class="text-lg font-semibold">{{ $carrito->producto->nombre }}</h3>
                                        <p class="text-gray-600">{{ $carrito->producto->precio }} &euro;</p>
                                        <div class="flex items-center mt-2">
                                            <form action="{{ route('decrementarCantidad', $carrito) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="bg-gray-300 text-black py-1 px-2 rounded hover:bg-gray-400" {{ $carrito->cantidad === 1 ? 'disabled' : '' }}>-</button>
                                            </form>
                                            <span class="mx-2">{{ $carrito->cantidad }}</span>
                                            <form action="{{ route('incrementarCantidad', $carrito) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="bg-gray-300 text-black py-1 px-2 rounded hover:bg-gray-400">+</button>
                                            </form>
                                        </div>
                                        <p class="mt-2 font-bold">Total: {{ $carrito->producto->precio * $carrito->cantidad }}&euro;</p>
                                    </div>
                                </div>
                                @php
                                    $precioTotal += $carrito->producto->precio * $carrito->cantidad;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/3 pl-4">
                        <div class="fixed w-1/3 bg-white p-4 shadow-md">
                            <div class="w-full text-center mb-4">
                                <span class="text-xl font-bold">Precio Total: </span>
                                <span class="font-bold text-xl">{{ $precioTotal }}&euro;</span>
                            </div>
                            <div class="w-full flex justify-center mb-4">
                                <form action="{{ route('completarCompra') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded w-full">
                                        Completar compra
                                    </button>
                                </form>
                            </div>
                            <div class="w-full flex justify-center">
                                <form action="{{ route('clear') }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <button class="hover:bg-red-500 bg-red-600 text-white border py-2 px-9 rounded w-full" type="submit">Vaciar carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
