@if ($pedidos->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="pedidos-table">
        <thead class="bg-teal-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Usuario</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Fecha de Compra</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Precio Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Productos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Transacción</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Actualizado en</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($pedidos as $pedido)
                <tr class="hover:bg-teal-200 cursor-pointer w-full pedido-row" data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $pedido->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $pedido->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ \Carbon\Carbon::parse($pedido->fecha_compra)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $pedido->precio_total }} &euro;</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ ucfirst($pedido->estado) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @foreach ($pedido->productos as $producto)
                            {{ $producto['nombre'] }} ({{ $producto['cantidad'] }})<br>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $pedido->transaccion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $pedido->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    {{ $pedidos->appends(['estado' => request('estado'), 'buscar' => request('buscar')])->links() }}

@else
    <p>No hay pedidos disponibles.</p>
@endif
