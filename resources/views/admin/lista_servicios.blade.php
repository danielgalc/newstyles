<!-- resources/views/admin/lista_servicios.blade.php -->
<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Servicios</h2>
    @if($servicios->count() > 0)
        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creado en</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actualizado en</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($servicios as $servicio)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->precio }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->duracion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->updated_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->clase }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay servicios disponibles.</p>
    @endif
</div>
