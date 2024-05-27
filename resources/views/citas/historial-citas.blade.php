<x-app-layout>
    <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
        <h2 class="font-righteous text-4xl text-gray-800 leading-tight">
            {{ __('Historial de Citas') }}
        </h2>
    </div>
    <div class="container mx-auto mt-4">
        @if($proximaCita)
        <div class="proxima-cita bg-white p-4 rounded-md shadow-md mb-6 hover:bg-teal-100 cursor-pointer" data-modal-toggle="edit_cita_modal_{{ $proximaCita->id }}" data-modal-target="edit_cita_modal_{{ $proximaCita->id }}">
            <h2 class="text-xl font-semibold text-teal-600 mb-2">
                @if($proximaCita->estado == 'aceptada' || $proximaCita->estado == 'pendiente' )
                Tu próxima cita es:
                @else
                Tu última cita fue:
                @endif
            </h2>
            <p><strong>Servicio:</strong> {{ $proximaCita->servicio }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($proximaCita->estado) }}</p>
        </div>
        @else
        <p class="mb-6">No tienes citas próximas.</p>
        @endif

        <h2 class="text-2xl font-semibold text-teal-600 mb-4">Citas Finalizadas</h2>
        @if($citasFinalizadas->isEmpty())
        <p>No tienes citas finalizadas.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($citasFinalizadas as $cita)
            <div class="cita-finalizada bg-white p-4 rounded-md shadow-md mb-4 hover:bg-teal-100 cursor-pointer" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">
                <p><strong>Servicio:</strong> {{ $cita->servicio }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</p>
            </div>
            @endforeach
        </div>
    {{ $citasFinalizadas->links() }}

        @endif
    </div>


    <!-- MODALES PARA EDITAR CITAS -->
    @if($proximaCita)
    <div id="edit_cita_modal_{{ $proximaCita->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Editar Cita: <span class="italic text-teal-600">#{{ $proximaCita->id }}</span>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_cita_modal_{{ $proximaCita->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <form id="edit_cita_form_{{ $proximaCita->id }}" action="{{ route('citas.updateFromHistorial', ['id' => $proximaCita->id]) }}" method="post" class="p-4 md:p-5">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="peluquero_id_{{ $proximaCita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peluquero</label>
                            <select name="peluquero_id" id="peluquero_id_{{ $proximaCita->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $proximaCita->peluquero_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="fecha_{{ $proximaCita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                            <input id="fecha_{{ $proximaCita->id }}" name="fecha" type="date" value="{{ $proximaCita->fecha }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>
                        <div class="col-span-2">
                            <label for="hora_{{ $proximaCita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
                            <input id="hora_{{ $proximaCita->id }}" name="hora" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}" placeholder="HH:mm" required>
                        </div>
                    </div>
                    <p id="change_hint_{{ $proximaCita->id }}" class="text-red-500 text-xs italic mb-2 hidden">Has de realizar cambios para poder guardar</p>
                    <div class="flex justify-between">
                        <button type="submit" id="submit_button_{{ $proximaCita->id }}" class="text-black bg-gray-300 inline-flex items-center cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center" disabled>
                            Guardar cambios
                        </button>
                        <button type="button" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="edit_cita_modal_{{ $proximaCita->id }}" data-modal-target="confirm_cancel_modal_{{ $proximaCita->id }}" data-modal-toggle="confirm_cancel_modal_{{ $proximaCita->id }}">
                            Cancelar cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL PARA CONFIRMAR CANCELADO DE CITAS -->
    @if($proximaCita)
    <div id="confirm_cancel_modal_{{ $proximaCita->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Confirmar cancelación
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_cancel_modal_{{ $proximaCita->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <p>¿Estás seguro de que quieres cancelar esta cita? ID: {{ $proximaCita->id }}</p>
                    <div class="flex justify-end items-center mt-4">
                        <form action="{{ route('citas.cancelar', ['id' => $proximaCita->id]) }}" method="post" class="p-4 md:p-5">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                Confirmar
                            </button>
                        </form>

                        <button type="button" class="h-10 text-gray-600 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" data-modal-toggle="confirm_cancel_modal_{{ $proximaCita->id }}">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edit_cita_form_{{ $proximaCita->id }}');
            const originalData = {
                peluquero_id: form.peluquero_id.value,
                fecha: form.fecha.value,
                hora: form.hora.value
            };
            const submitButton = document.getElementById('submit_button_{{ $proximaCita->id }}');
            const changeHint = document.getElementById('change_hint_{{ $proximaCita->id }}');

            form.addEventListener('input', function() {
                const newData = {
                    peluquero_id: form.peluquero_id.value,
                    fecha: form.fecha.value,
                    hora: form.hora.value
                };

                const isChanged = originalData.peluquero_id !== newData.peluquero_id ||
                    originalData.fecha !== newData.fecha ||
                    originalData.hora !== newData.hora;

                submitButton.disabled = !isChanged;
                submitButton.classList.toggle('bg-blue-700', isChanged);
                submitButton.classList.toggle('hover:bg-blue-800', isChanged);
                submitButton.classList.toggle('text-white', isChanged);
                submitButton.classList.toggle('bg-gray-300', !isChanged);
                submitButton.classList.toggle('text-black', !isChanged);
                submitButton.classList.toggle('cursor-not-allowed', !isChanged);

                changeHint.classList.toggle('hidden', isChanged);
            });
        });
    </script>
</x-app-layout>