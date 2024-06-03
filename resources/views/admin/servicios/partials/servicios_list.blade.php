@if ($servicios->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="services-table">
        <thead class="bg-teal-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Precio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Duración</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Creado en</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Actualizado en</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Clase</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($servicios as $servicio)
                <tr class="hover:bg-teal-200 cursor-pointer w-full service-row" data-clase="{{ $servicio->clase }}" data-modal-toggle="edit_servicio_modal_{{ $servicio->id }}" data-modal-target="edit_servicio_modal_{{ $servicio->id }}">
                    <div>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->precio }} &euro;</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->duracion }} minutos</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->updated_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $servicio->clase == 'principal' ? 'Principal' : 'Secundario' }}</td>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Mostrar enlaces de paginación -->
    {{ $servicios->appends(['clase' => request('clase')])->links() }}
@else
    <p>No hay servicios disponibles.</p>
@endif
