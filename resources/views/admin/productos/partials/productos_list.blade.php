@if ($productos->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="productos-table">
        <thead class="bg-teal-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Descripción</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Precio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Imagen</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Categoría</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Actualizado en</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($productos as $producto)
                <tr class="hover:bg-teal-200 cursor-pointer w-full producto-row" data-categoria="{{ $producto->categoria }}" data-modal-toggle="edit_producto_modal_{{ $producto->id }}" data-modal-target="edit_producto_modal_{{ $producto->id }}">
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ Str::limit($producto->descripcion, $limit = 20, $end = '...') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->precio }} &euro;</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->imagen }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->stock }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->categoria }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    {{ $productos->appends(['categoria' => request('categoria')])->links() }}

@else
    <p>No hay productos disponibles.</p>
@endif
