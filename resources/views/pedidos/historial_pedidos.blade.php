<x-app-layout>
    <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
        <h2 class="text-4xl text-gray-800 leading-tight banner-text">
            {{ __('Historial de Pedidos') }}
        </h2>
    </div>
    <div class="container mx-auto mt-4">
        @if($pedidoReciente)
            <div class="proximo-pedido bg-white p-4 rounded-md shadow-md mb-6 hover:bg-teal-100 cursor-pointer" onclick="mostrarDetalles({{ $pedidoReciente->id }})">
                <h2 class="text-xl font-semibold text-teal-600 mb-2">
                    Tu pedido más reciente es:
                </h2>
                <p><strong>Fecha de Compra:</strong> {{ \Carbon\Carbon::parse($pedidoReciente->fecha_compra)->format('d/m/Y') }}</p>
                <p><strong>Precio Total:</strong> {{ $pedidoReciente->precio_total }} €</p>
                <p><strong>Estado:</strong> {{ ucfirst($pedidoReciente->estado) }}</p>
            </div>
        @else
            @if($pedidos->currentPage() == 1)
                <h2 class="text-2xl font-semibold text-teal-600 mb-4">Tu pedido más reciente es:</h2>
                <p class="mb-6">No tienes pedidos recientes.</p>
            @endif
        @endif

        <h2 class="text-2xl font-semibold text-teal-600 mb-4">Pedidos Anteriores</h2>
        @if($pedidos->total() > 1 || $pedidos->currentPage() > 1)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pedidos as $pedido)
                    @if($loop->first && $pedidos->currentPage() == 1)
                        @continue
                    @endif
                    <div class="pedido-anterior bg-white p-4 rounded-md shadow-md mb-4 hover:bg-teal-100 cursor-pointer" onclick="mostrarDetalles({{ $pedido->id }})">
                        <p><strong>Fecha de Compra:</strong> {{ \Carbon\Carbon::parse($pedido->fecha_compra)->format('d/m/Y') }}</p>
                        <p><strong>Precio Total:</strong> {{ $pedido->precio_total }} €</p>
                        <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p>No tienes pedidos anteriores.</p>
        @endif

        <!-- Enlaces de paginación -->
        <div class="mt-4">
            {{ $pedidos->links() }}
        </div>
    </div>

    <!-- Div para mostrar los detalles del pedido -->
    <div id="detallesPedido" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl font-semibold text-teal-600 mb-4">Detalles del Pedido</h2>
            <div id="detallesContenido" class="grid grid-cols-2 gap-4"></div>
            <button class="mt-4 bg-teal-500 text-white py-2 px-4 rounded" onclick="cerrarDetalles()">Cerrar</button>
            <a id="descargarPDF" href="#" target="_blank" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hidden">Descargar PDF</a>
            <button id="cancelarPedido" class="mt-4 bg-red-500 text-white py-2 px-4 rounded hidden" onclick="abrirConfirmacion()">Cancelar</button>
        </div>
    </div>

    <!-- Modal para confirmar la cancelación -->
    <div id="confirmarCancelacion" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-semibold text-red-600 mb-4">Confirmar Cancelación</h2>
            <p>¿Estás seguro de que deseas cancelar este pedido?</p>
            <div class="flex justify-end mt-4">
                <button class="bg-gray-300 text-black py-2 px-4 rounded mr-2" onclick="cerrarConfirmacion()">No</button>
                <button id="confirmarCancelar" class="bg-red-500 text-white py-2 px-4 rounded">Sí, cancelar</button>
            </div>
        </div>
    </div>

    <!-- Incluir Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function mostrarDetalles(id) {
            axios.get(`/pedidos/${id}`)
                .then(response => {
                    const pedido = response.data;
                    let detallesHtml = `
                        <p><strong>Transacción:</strong> ${pedido.transaccion}</p>
                        <p><strong>Fecha de Compra:</strong> ${new Date(pedido.fecha_compra).toLocaleDateString()}</p>
                        <p><strong>Precio Total:</strong> ${pedido.precio_total} €</p>
                        <p><strong>DNI:</strong> ${pedido.dni}</p>
                        <p><strong>Teléfono:</strong> ${pedido.telefono}</p>
                        <p><strong>Dirección:</strong> ${pedido.direccion}</p>
                        <h2 class="text-xl font-semibold text-teal-600 mb-2">Productos Comprados:</h2>
                        <ul>
                    `;
                    pedido.productos.forEach(producto => {
                        detallesHtml += `<li>${producto.nombre} (${producto.pivot.cantidad})</li>`;
                    });
                    detallesHtml += '</ul>';

                    document.getElementById('detallesContenido').innerHTML = detallesHtml;
                    document.getElementById('descargarPDF').href = `/pedidos/${pedido.id}/pdf`;
                    document.getElementById('detallesPedido').classList.remove('hidden');
                    if (pedido.estado !== 'Cancelado') {
                        document.getElementById('descargarPDF').classList.remove('hidden');
                        document.getElementById('cancelarPedido').classList.remove('hidden');
                        document.getElementById('cancelarPedido').setAttribute('data-pedido-id', pedido.id);
                    } else {
                        document.getElementById('descargarPDF').classList.add('hidden');
                        document.getElementById('cancelarPedido').classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching pedido details:', error);
                });
        }

        function cerrarDetalles() {
            document.getElementById('detallesPedido').classList.add('hidden');
        }

        function abrirConfirmacion() {
            document.getElementById('confirmarCancelacion').classList.remove('hidden');
        }

        function cerrarConfirmacion() {
            document.getElementById('confirmarCancelacion').classList.add('hidden');
        }

        document.getElementById('confirmarCancelar').addEventListener('click', function() {
            const pedidoId = document.getElementById('cancelarPedido').getAttribute('data-pedido-id');
            axios.post(`/pedidos/cancelar/${pedidoId}`, {
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    alert('Pedido cancelado con éxito.');
                    cerrarConfirmacion();
                    cerrarDetalles();
                    location.reload();
                } else {
                    alert('Hubo un error al cancelar el pedido.');
                }
            })
            .catch(error => {
                console.error('Error al cancelar el pedido:', error);
            });
        });
    </script>
</x-app-layout>
