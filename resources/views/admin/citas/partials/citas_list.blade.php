@if ($citas->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Usuario</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Peluquero</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Servicio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Fecha</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Hora</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Cambiar estado</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($citas as $cita)
            <tr class="hover:bg-teal-200 cursor-pointer w-full cita-row" data-estado="{{ $cita->estado }}">
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->peluquero->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->servicio }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->fecha }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->hora }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">{{ $cita->estado }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <form action="{{ route('citas.actualizar_estado', ['id' => $cita->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="estado" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full text-center p-2.5">
                            <option value="" selected disabled>Elegir estado</option>    
                            <option value="aceptada" {{ $cita->estado == 'aceptada' ? '' : '' }}>Aceptada</option>
                            <option value="cancelada" {{ $cita->estado == 'cancelada' ? '' : '' }}>Cancelada</option>
                            <option value="finalizada" {{ $cita->estado == 'finalizada' ? '' : '' }}>Finalizada</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    {{ $citas->appends(['estado' => request('estado')])->links() }}
@else
    <p>No hay citas disponibles.</p>
@endif
