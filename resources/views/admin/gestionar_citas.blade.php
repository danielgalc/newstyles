<!-- resources/views/admin/citas.blade.php -->
<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Citas</h2>
    @if($citas->count() > 0)
        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peluquero</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <!-- Agrega más columnas según tus necesidades -->
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($citas as $cita)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->peluquero->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->servicio }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->fecha }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->hora->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->estado }}</td>
                        <!-- Agrega más celdas según tus necesidades -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay citas disponibles.</p>
    @endif
</div>
