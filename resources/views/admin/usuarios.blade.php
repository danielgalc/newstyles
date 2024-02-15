<!-- resources/views/admin/usuarios.blade.php -->
<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Usuarios</h2>
    @if($usuarios->count() > 0)
        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <!-- TODO -->
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($usuarios as $usuario)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->email }}</td>
                        <!-- TODO -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay usuarios disponibles.</p>
    @endif
</div>
