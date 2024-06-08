@if ($bloqueos->count() > 0)
<table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
    <thead class="bg-teal-600">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Peluquero</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Fecha</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider text-center">Horas Bloqueadas</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($bloqueos as $bloqueo)
        <tr class="hover:bg-teal-200 cursor-pointer w-full bloqueo-row">
            <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_bloqueo_modal_{{ $bloqueo->id }}" data-modal-target="edit_bloqueo_modal_{{ $bloqueo->id }}">{{ $bloqueo->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_bloqueo_modal_{{ $bloqueo->id }}" data-modal-target="edit_bloqueo_modal_{{ $bloqueo->id }}">{{ $bloqueo->peluquero->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_bloqueo_modal_{{ $bloqueo->id }}" data-modal-target="edit_bloqueo_modal_{{ $bloqueo->id }}">{{ $bloqueo->fecha }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-center" data-modal-toggle="edit_bloqueo_modal_{{ $bloqueo->id }}" data-modal-target="edit_bloqueo_modal_{{ $bloqueo->id }}">
                @php
                    $horas = is_string($bloqueo->horas) ? json_decode($bloqueo->horas, true) : $bloqueo->horas;
                @endphp
                @if (is_array($horas))
                    @foreach ($horas as $hora)
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $hora)->format('H:i') }}
                        @if (!$loop->last), @endif
                    @endforeach
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Mostrar enlaces de paginación -->
{{ $bloqueos->links() }}
@else
<p>No hay bloqueos disponibles.</p>
@endif
