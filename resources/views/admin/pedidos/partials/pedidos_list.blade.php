@if ($pedidos->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="pedidos-table">
        <thead class="bg-teal-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Usuario</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Fecha de Compra</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Precio Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Transacción</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($pedidos as $pedido)
                <tr class="hover:bg-teal-200 cursor-pointer w-full pedido-row">
                    <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">{{ $pedido->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">
                        {{ $pedido->user->name ?? 'Usuario Eliminado' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">{{ \Carbon\Carbon::parse($pedido->fecha_compra)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">{{ $pedido->precio_total }} &euro;</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center"data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">{{ ucfirst($pedido->estado) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center"data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="edit_pedido_modal_{{ $pedido->id }}">{{ $pedido->transaccion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 z-1" data-modal-toggle="productos_pedido_modal_{{ $pedido->id }}" data-modal-target="productos_pedido_modal_{{ $pedido->id }}">Ver Productos</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    {{ $pedidos->appends(['estado' => request('estado'), 'buscar' => request('buscar')])->links() }}
@else
    <p>No hay pedidos disponibles.</p>
@endif
