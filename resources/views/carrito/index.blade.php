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
                            @foreach ($carritos as $carrito)
                                <div class="flex bg-white rounded-md shadow-md p-4 mb-4 items-center">
                                    <img src="/images/productos/{{ $carrito->producto->imagen }}" alt="{{ $carrito->producto->nombre }}" class="w-24 h-24 object-cover rounded-md">
                                    <div class="flex-1 ml-4">
                                        <h3 class="text-lg font-semibold">{{ $carrito->producto->nombre }}</h3>
                                        <p class="text-gray-600">{{ $carrito->producto->precio }} &euro;</p>
                                        <div class="flex items-center mt-2">
                                            <form action="{{ route('decrementarCantidad', $carrito->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="bg-gray-300 text-black py-1 px-2 rounded hover:bg-gray-400">-</button>
                                            </form>
                                            <span class="mx-2">{{ $carrito->cantidad }}</span>
                                            <form action="{{ route('incrementarCantidad', $carrito->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="bg-gray-300 text-black py-1 px-2 rounded hover:bg-gray-400">+</button>
                                            </form>
                                        </div>
                                        <p class="mt-2 font-bold">Total: {{ $carrito->producto->precio * $carrito->cantidad }}&euro;</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/3 pl-4">
                        <div class="w-full bg-white p-4 shadow-md">
                            <div class="w-full text-center mb-4 py-10 font-righteous">
                                <span class="text-xl font-bold">Precio Total: </span>
                                <span class="font-bold text-xl text-teal-500">{{ $precioTotal }}&euro;</span>
                            </div>
                            <div>
                                {{-- Botón de PayPal --}}
                                <div id="paypal-button-container"></div>
                                <div id="compra-completada-message"
                                    class="hidden bg-green-200 text-green-800 border border-green-400 p-4 rounded mt-4">
                                    Compra completada
                                </div>
                            </div>
                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded w-full" onclick="toggleModal('confirm_clear_modal')">Vaciar carrito</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para confirmar vaciar carrito -->
    <div id="confirm_clear_modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Confirmar vaciado de carrito
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="toggleModal('confirm_clear_modal')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <p class="dark:text-white">¿Estás seguro de que deseas vaciar el carrito? Esta acción no se puede deshacer.</p>
                    <div class="flex justify-end items-center mt-4">
                        <form action="{{ route('clear') }}" method="post" class="inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="confirmar_vaciar">
                                Confirmar
                            </button>
                        </form>

                        <button type="button" class="h-10 text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-100 dark:hover:bg-gray-300 dark:focus:ring-gray-800 ml-2" onclick="toggleModal('confirm_clear_modal')">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=EUR"></script>
    <script nonce="random_nonce_value">
        document.addEventListener("DOMContentLoaded", function() {
            const precioTotal = {{ $precioTotal }};
            paypal.Buttons({
                createOrder: function(data, actions) {
                    // Crea el pedido de PayPal
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: precioTotal.toFixed(2),
                                currency_code: 'EUR'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    // Captura el pago cuando se aprueba
                    return actions.order.capture().then(function(details) {
                        alert('Pago completado por ' + details.payer.name.given_name);
                        document.getElementById('paypal-button-container').style.display = 'none';
                        document.getElementById('compra-completada-message').style.display = 'block';

                        // Realiza la compra en el servidor
                        axios.post('{{ route('completarCompra') }}', {
                            _token: '{{ csrf_token() }}'
                        }).then(function(response) {
                            console.log('Compra completada:', response.data);
                            window.location.href = '{{ route('carrito') }}';
                        }).catch(function(error) {
                            console.error('Error al completar la compra:', error);
                        });
                    });
                }
            }).render('#paypal-button-container');
        });

        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
        }
    </script>
</x-app-layout>
