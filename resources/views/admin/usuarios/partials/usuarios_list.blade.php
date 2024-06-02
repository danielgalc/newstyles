@if ($usuarios->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="users-table">
        <thead class="bg-teal-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Rol</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Verificado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Última Modificación</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($usuarios as $usuario)
                <tr class="hover:bg-teal-200 cursor-pointer w-full" data-modal-toggle="edit_user_modal_{{ $usuario->id }}" data-modal-target="edit_user_modal_{{ $usuario->id }}">
                    <div>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $usuario->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $usuario->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($usuario->rol === 'cliente')
                                Cliente
                            @elseif($usuario->rol === 'admin')
                                Admin
                            @else
                                Peluquero
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($usuario->email_verified_at)
                                Verificado
                            @else
                                No verificado
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">{{ $usuario->updated_at }}</td>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Mostrar enlaces de paginación -->
    {{ $usuarios->appends(['rol' => request('rol')])->links() }}
@else
    <p>No hay usuarios disponibles.</p>
@endif
