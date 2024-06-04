@extends('layouts.admin_layout')

@section('title', 'Gestionar Bloqueos')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Listado de Bloqueos</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Añadir nuevo bloqueo
        </button>
    </div>

    <div id="bloqueos-content">
        @include('admin.bloqueos.partials.bloqueos_list', ['bloqueos' => $bloqueos])
    </div>
</div>

<!-- MODAL PARA EDITAR BLOQUEOS -->
@foreach ($bloqueos as $bloqueo)
<div id="edit_bloqueo_modal_{{ $bloqueo->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Bloqueo: <span class="italic text-teal-600">#{{ $bloqueo->id }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_bloqueo_modal_{{ $bloqueo->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- Form Editar -->
            <form action="{{ route('bloqueos.update', ['id' => $bloqueo->id]) }}" id="edit_bloqueo_form_{{ $bloqueo->id }}" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="peluquero_id_edit_{{ $bloqueo->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peluquero</label>
                        <select name="peluquero_id" id="peluquero_id_edit_{{ $bloqueo->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($peluqueros as $peluquero)
                                <option value="{{ $peluquero->id }}" {{ $bloqueo->peluquero_id == $peluquero->id ? 'selected' : '' }}>{{ $peluquero->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="fecha_edit_{{ $bloqueo->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                        <input id="fecha_edit_{{ $bloqueo->id }}" name="fecha" type="date" value="{{ $bloqueo->fecha }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-span-2">
                        <label for="horas_edit_{{ $bloqueo->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Horas</label>
                        <select id="horas_edit_{{ $bloqueo->id }}" name="horas[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                            @foreach (['10:00', '11:00', '12:00', '13:00', '16:00', '17:00', '18:00', '19:00', '20:00'] as $hora)
                                <option value="{{ $hora }}:00" {{ in_array($hora.':00', json_decode($bloqueo->horas, true)) ? 'selected' : '' }}>{{ $hora }}</option>
                            @endforeach
                        </select>
                        <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
                    </div>
                </div>
                <div class="flex justify-between">
                    <button type="submit" id="submit_button_edit_{{ $bloqueo->id }}" class="text-white inline-flex items-center bg-teal-500 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800">Guardar cambios</button>
                    <button type="button" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="edit_bloqueo_modal_{{ $bloqueo->id }}" data-modal-target="confirm_delete_modal_{{ $bloqueo->id }}" data-modal-toggle="confirm_delete_modal_{{ $bloqueo->id }}">Eliminar bloqueo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA CONFIRMAR BORRADO DE BLOQUEOS -->
<div id="confirm_delete_modal_{{ $bloqueo->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirmar eliminación
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_delete_modal_{{ $bloqueo->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <p class="dark:text-white">¿Estás seguro de que quieres eliminar este bloqueo? <br> <span class="text-teal-400 italic">ID: {{ $bloqueo->id }}</span></p>
                <div class="flex justify-end items-center mt-4">
                    <form action="{{ route('bloqueos.destroy', ['id' => $bloqueo->id]) }}" method="post" class="p-4 md:p-5">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $bloqueo->id }}" data-delete-route="{{ route('bloqueos.destroy', ['id' => $bloqueo->id]) }}">
                        <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="confirmar_eliminar">
                            Confirmar
                        </button>
                    </form>
                    <button type="button" class="h-10 text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-100 dark:hover:bg-gray-300 dark:focus:ring-gray-800" data-modal-toggle="confirm_delete_modal_{{ $bloqueo->id }}" data-delete-route="{{ route('bloqueos.destroy', ['id' => $bloqueo->id]) }}">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL PARA CREAR BLOQUEOS -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Añadir Nuevo Bloqueo
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <form action="{{ route('bloqueos.store') }}" id="crearForm" method="post" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="peluquero_id_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peluquero</label>
                        <select name="peluquero_id" id="peluquero_id_crear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach ($peluqueros as $peluquero)
                                <option value="{{ $peluquero->id }}">{{ $peluquero->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="fecha_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                        <input id="fecha_crear" name="fecha" type="date" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                    </div>
                    <div class="col-span-2">
                        <label for="horas_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Horas</label>
                        <select id="horas_crear" name="horas[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple required>
                            @foreach (['10:00', '11:00', '12:00', '13:00', '16:00', '17:00', '18:00', '19:00', '20:00'] as $hora)
                                <option value="{{ $hora }}:00">{{ $hora }}</option>
                            @endforeach
                        </select>
                        <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
                    </div>
                </div>
                <button type="submit" id="submit_button_crear" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Añadir nuevo bloqueo</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function iniciarScriptsModales(modalId) {
        const fechaInput = document.getElementById('fecha_' + modalId);
        const peluqueroInput = document.getElementById('peluquero_id_' + modalId);
        const horasInput = document.getElementById('horas_' + modalId);

        const form = document.getElementById(modalId === 'crear' ? 'crearForm' : 'edit_bloqueo_form_' + modalId.split('_')[1]);

        const today = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('min', today);

        function validarFecha(showError = false) {
            const selectedDate = new Date(fechaInput.value);
            const day = selectedDate.getUTCDay();

            if (day === 0 || day === 6) {
                fechaInput.value = '';
                if (showError) {
                    alert('No se pueden seleccionar fines de semana. Por favor, elige otro día.');
                }
                return false;
            } else if (fechaInput.value === '') {
                if (showError) {
                    alert('Selecciona una fecha antes de elegir una hora');
                }
                return false;
            }

            return true;
        }

        form.addEventListener('submit', function(event) {
            if (!validarFecha(true)) {
                event.preventDefault();
            }
        });

        fechaInput.addEventListener('input', function() {
            if (validarFecha(true)) {
                horasInput.disabled = false;
            } else {
                horasInput.disabled = true;
            }
        });

        if (!fechaInput.value) {
            horasInput.disabled = true;
        } else {
            horasInput.disabled = false;
        }
    }

    @foreach($bloqueos as $bloqueo)
    iniciarScriptsModales('edit_{{ $bloqueo->id }}');
    @endforeach

    iniciarScriptsModales('crear');
});

</script>

@endsection
