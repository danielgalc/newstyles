<x-app-layout>
    <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
        <h2 class="text-4xl text-gray-800 leading-tight banner-text">
            {{ __('Historial de Citas') }}
        </h2>
    </div>
    <div class="container mx-auto mt-4">
        @if($proximaCita)
        @if($proximaCita->estado == 'aceptada' || $proximaCita->estado == 'pendiente')
        <div class="proxima-cita bg-white p-4 rounded-md shadow-md mb-6 hover:bg-teal-100 cursor-pointer" data-modal-toggle="edit_cita_modal_{{ $proximaCita->id }}" data-modal-target="edit_cita_modal_{{ $proximaCita->id }}">
            <h2 class="text-xl font-semibold text-teal-600 mb-2">
                Tu próxima cita es:
            </h2>
            <p><strong>Servicio:</strong> {{ $proximaCita->servicio }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}</p>
            <p><strong>Peluquero:</strong> {{ $proximaCita->peluquero->name }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($proximaCita->estado) }}</p>
        </div>
        @elseif($proximaCita->estado == 'finalizada' || $proximaCita->estado == 'cancelada' )
        <div class="proxima-cita bg-white p-4 rounded-md shadow-md mb-6 hover:bg-teal-100">
            <h2 class="text-xl font-semibold text-teal-600 mb-2">
                Tu última cita fue:
            </h2>
            <p><strong>Servicio:</strong> {{ $proximaCita->servicio }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}</p>
            <p><strong>Peluquero:</strong> {{ $proximaCita->peluquero->name }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($proximaCita->estado) }}</p>
        </div>
        @endif
        @else
        <h2 class="text-2xl font-semibold text-teal-600 mb-4">Tu próxima cita es:</h2>

        <p class="mb-6">No tienes citas próximas.</p>
        @endif

        <h2 class="text-2xl font-semibold text-teal-600 mb-4">Citas Finalizadas</h2>
        @if($citasFinalizadas->isEmpty())
        <p>No tienes citas finalizadas.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($citasFinalizadas as $cita)
            <div class="cita-finalizada bg-white p-4 rounded-md shadow-md mb-4 hover:bg-teal-100" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">
                <p><strong>Servicio:</strong> {{ $cita->servicio }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</p>
                <p><strong>Peluquero:</strong> {{ $cita->peluquero->name }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($cita->estado) }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- MODALES PARA EDITAR CITAS -->
    @if($proximaCita)
    <div id="edit_cita_modal_{{ $proximaCita->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Editar Cita:</span>
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
                    <div class="grid gap-4 mb-4 grid-cols-1">
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
                            <select id="hora_{{ $proximaCita->id }}" name="hora" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed" required disabled>
                                <option value="">Selecciona una hora</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="servicio_{{ $proximaCita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicio</label>
                            <select name="servicio" id="servicio_{{ $proximaCita->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}" {{ $proximaCita->servicio_id == $servicio->id ? 'selected' : '' }}>{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p id="texto_cambio_{{ $proximaCita->id }}" class="text-red-500 text-xs italic mb-2 hidden">Has de realizar cambios para poder guardar</p>
                    <p id="texto_hora_{{ $proximaCita->id }}" class="text-red-500 text-xs italic mb-2 hidden">No puedes hacer cambios a falta de menos de 24 horas para tu cita.</p>
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
            var fechaInput = document.getElementById('fecha_{{ $proximaCita->id }}');
            var peluqueroInput = document.getElementById('peluquero_id_{{ $proximaCita->id }}');
            var horaInput = document.getElementById('hora_{{ $proximaCita->id }}');
            var submitButton = document.getElementById('submit_button_{{ $proximaCita->id }}');
            var errorMessage = document.createElement('p');
            errorMessage.className = 'text-red-500 text-xs italic mb-2 mt-2';
            errorMessage.style.display = 'none';
            fechaInput.parentNode.insertBefore(errorMessage, fechaInput.nextSibling);

            // Establecer la fecha mínima a hoy
            var today = new Date().toISOString().split('T')[0];
            fechaInput.setAttribute('min', today);

            // Función para deshabilitar el input de hora
            function deshabilitarHoraInput() {
                horaInput.disabled = true;
                horaInput.classList.add('cursor-not-allowed');
            }

            // Función para habilitar el input de hora
            function habilitarHoraInput() {
                horaInput.disabled = false;
                horaInput.classList.remove('cursor-not-allowed');
            }

            // Generar opciones de tiempo disponibles
            function generarHorasOptions() {
                const times = [];
                const timeRanges = [{
                        start: 10,
                        end: 13
                    },
                    {
                        start: 16,
                        end: 20
                    }
                ];

                timeRanges.forEach(range => {
                    for (let i = range.start; i <= range.end; i++) {
                        times.push(`${String(i).padStart(2, '0')}:00:00`);
                    }
                });

                return times;
            }

            // Obtener la hora actual en formato HH:MM:SS
            function getHoraActual() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                return `${hours}:${minutes}:00`;
            }

            // Validar la fecha seleccionada
            function validarFecha() {
                const selectedDate = new Date(fechaInput.value);
                const day = selectedDate.getUTCDay();

                if (day === 0 || day === 6) {
                    fechaInput.value = ''; // Resetear el campo de fecha
                    errorMessage.textContent = 'No se pueden seleccionar fines de semana. Por favor, elige otro día.';
                    errorMessage.style.display = 'block';
                    deshabilitarHoraInput(); // Deshabilitar el input de hora
                    return;
                } else if (fechaInput.value === '') {
                    errorMessage.textContent = 'Selecciona una fecha antes de elegir una hora';
                    errorMessage.style.display = 'block';
                    deshabilitarHoraInput(); // Deshabilitar el input de hora
                    return;
                }

                errorMessage.style.display = 'none';
                habilitarHoraInput(); // Habilitar el input de hora
                obtenerCitas(peluqueroInput.value, fechaInput.value);
            }

            // Obtener citas disponibles para el peluquero seleccionado en la fecha seleccionada
            function obtenerCitas(peluqueroId, fecha) {
                if (!peluqueroId || !fecha) {
                    horaInput.innerHTML = '<option value="" disabled selected>Selecciona una hora</option>';
                    return;
                }

                console.log('Obteniendo citas para peluquero:', peluqueroId, 'en la fecha:', fecha);

                fetch(`/citas/obtenerCitas?peluquero_id=${peluqueroId}&fecha=${fecha}`)
                    .then(response => response.json())
                    .then(citas => {
                        console.log('Citas obtenidas:', citas);
                        // Llamada a actualizarHorasDisponibles con la fecha pasada como argumento
                        actualizarHorasDisponibles(citas, fecha); // Cambio: se pasa 'fecha' como segundo parámetro
                    })
                    .catch(error => console.error('Error obteniendo citas:', error));
            }

            // Actualizar opciones del select de hora
            function actualizarHorasDisponibles(citas, fecha) { // Cambio: se añade 'fecha' como parámetro
                horaInput.innerHTML = '<option value="" disabled selected>Selecciona una hora</option>';
                // Cambio: filtrar las citas por la fecha pasada como parámetro
                const occupiedTimes = citas
                    .filter(cita => cita.fecha === fecha) // Cambio: filtro por fecha específica
                    .map(cita => `${cita.hora}`);
                console.log('Horas ocupadas:', occupiedTimes);
                const horasDisponibles = generarHorasOptions().filter(time => !occupiedTimes.includes(time));

                horasDisponibles.push('{{ $proximaCita->hora }}');

                horasDisponibles.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time.slice(0, 5); // Mostrar solo HH:MM
                    if (time === '{{ $proximaCita->hora }}') {
                        option.textContent = `${time.slice(0, 5)} - Hora seleccionada`;
                    } else {
                        option.textContent = time.slice(0, 5);
                    }
                    horaInput.appendChild(option);
                });

                // Deshabilitar horas pasadas si la fecha es hoy
                const today = new Date().toISOString().split('T')[0];
                if (fechaInput.value === today) {
                    const currentTime = getHoraActual();
                    horaInput.querySelectorAll('option').forEach(option => {
                        if (option.value && option.value < currentTime.slice(0, 5)) {
                            option.disabled = true;
                        }
                    });
                }

                horaInput.value = '{{ $proximaCita->hora }}'.slice(0, 5);
            }

            // Event listener para el cambio de peluquero
            peluqueroInput.addEventListener('change', function() {
                if (fechaInput.value) {
                    obtenerCitas(this.value, fechaInput.value);
                }
            });

            // Agregar el listener al campo de fecha
            fechaInput.addEventListener('input', function() {
                validarFecha();
            });

            // Deshabilitar el input de hora al cargar la página si no hay fecha seleccionada
            if (!fechaInput.value) {
                deshabilitarHoraInput();
            }

            // Validar la fecha al cargar la página
            validarFecha();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($proximaCita)
            const form = document.getElementById('edit_cita_form_{{ $proximaCita->id }}');
            const originalData = {
                peluquero_id: form.peluquero_id.value,
                fecha: form.fecha.value,
                hora: form.hora.value,
                servicio: form.servicio.value
            };
            const submitButton = document.getElementById('submit_button_{{ $proximaCita->id }}');
            const textoCambio = document.getElementById('texto_cambio_{{ $proximaCita->id }}');
            const textoHora = document.getElementById('texto_hora_{{ $proximaCita->id }}');

            function comprobRestricionHora() {
                const now = new Date();
                const citaFecha = new Date(form.fecha.value + 'T' + form.hora.value);
                const diff = citaFecha - now;
                const hoursDiff = diff / 1000 / 60 / 60;

                return hoursDiff < 24;
            }

            form.addEventListener('input', function() {
                const newData = {
                    peluquero_id: form.peluquero_id.value,
                    fecha: form.fecha.value,
                    hora: form.hora.value,
                    servicio: form.servicio.value
                };

                const isChanged = originalData.peluquero_id !== newData.peluquero_id ||
                    originalData.fecha !== newData.fecha ||
                    originalData.hora !== newData.hora ||
                    originalData.servicio !== newData.servicio;

                const isTimeRestricted = comprobRestricionHora();

                submitButton.disabled = !isChanged || isTimeRestricted;
                submitButton.classList.toggle('bg-blue-700', isChanged && !isTimeRestricted);
                submitButton.classList.toggle('hover:bg-blue-800', isChanged && !isTimeRestricted);
                submitButton.classList.toggle('text-white', isChanged && !isTimeRestricted);
                submitButton.classList.toggle('bg-gray-300', !isChanged || isTimeRestricted);
                submitButton.classList.toggle('text-black', !isChanged || isTimeRestricted);
                submitButton.classList.toggle('cursor-not-allowed', !isChanged || isTimeRestricted);

                textoCambio.classList.toggle('hidden', isChanged);
                textoHora.classList.toggle('hidden', !isTimeRestricted);
            });
            @endif
        });
    </script>
</x-app-layout>
