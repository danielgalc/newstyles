@extends('layouts.admin_layout')

@section('title', 'Gestionar Citas')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Listado de Citas</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Añadir nueva cita
        </button>
    </div>

    <!-- FILTRO POR ESTADO -->
    <div class="mb-4">
        <form method="GET" action="{{ route('admin.citas') }}" id="filter-form">
            <select class="rounded" name="estado" id="filtro-citas" onchange="document.getElementById('filter-form').submit();">
                <option value="" {{ request('estado') == '' ? 'selected' : '' }}>Mostrar todo</option>
                <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                <option value="finalizada" {{ request('estado') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
            </select>
        </form>
    </div>

    <div id="citas-content">
        @include('admin.citas.partials.citas_list', ['citas' => $citas])
    </div>
</div>

<!-- MODAL PARA EDITAR CITAS -->
@foreach ($citas as $cita)
<div id="edit_cita_modal_{{ $cita->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Cita: <span class="italic text-teal-600">#{{ $cita->id }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_cita_modal_{{ $cita->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- Form Editar -->
            <form action="{{ route('citas.update', ['id' => $cita->id]) }}" id="edit_cita_form_{{ $cita->id }}" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="user_id_edit_{{ $cita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Cliente</label>
                        <input type="text" name="user_id" id="user_id_edit_{{ $cita->id }}" value="{{ $cita->user_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Introduzca el ID del cliente" required>
                    </div>
                    <div class="col-span-2">
                        <label for="peluquero_id_edit_{{ $cita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peluquero</label>
                        <select name="peluquero_id" id="peluquero_id_edit_{{ $cita->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $cita->peluquero_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="fecha_edit_{{ $cita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                        <input id="fecha_edit_{{ $cita->id }}" name="fecha" type="date" value="{{ $cita->fecha }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    </div>
                    <div class="col-span-2">
                        <label for="hora_edit_{{ $cita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
                        <select id="hora_edit_{{ $cita->id }}" name="hora" class="mt-1 p-2 block w-full border border-gray-300 rounded-md cursor-not-allowed" required disabled>
                            <option value="">Selecciona una hora</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="servicio_edit_{{ $cita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicio</label>
                        <select name="servicio" id="servicio_edit_{{ $cita->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}" {{ $cita->servicio_id == $servicio->id ? 'selected' : '' }}>{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="estado_edit_{{ $cita->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <select name="estado" id="estado_edit_{{ $cita->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="aceptada" {{ $cita->estado == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                            <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="finalizada" {{ $cita->estado == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        </select>
                    </div>
                </div>
                <p id="texto_cambio_edit_{{ $cita->id }}" class="hidden text-red-500 text-xs italic mb-2">Has de realizar cambios para poder guardar</p>
                <p id="texto_hora_edit_{{ $cita->id }}" class="hidden text-red-500 text-xs italic mb-2">No puedes hacer cambios a falta de menos de 24 horas para tu cita.</p>
                <div class="flex justify-between">
                    <button type="submit" id="submit_button_edit_{{ $cita->id }}" class="text-black bg-gray-300 inline-flex items-center cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center" disabled>Guardar cambios</button>
                    <button type="button" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center" data-modal-hide="edit_cita_modal_{{ $cita->id }}" data-modal-target="confirm_delete_modal_{{ $cita->id }}" data-modal-toggle="confirm_delete_modal_{{ $cita->id }}">Eliminar cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA CONFIRMAR BORRADO DE CITAS -->
<div id="confirm_delete_modal_{{ $cita->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirmar eliminación
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_delete_modal_{{ $cita->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <p>¿Estás seguro de que quieres eliminar esta cita? ID: {{ $cita->id }}</p>
                <div class="flex justify-end items-center mt-4">
                    <form action="{{ route('citas.destroy', ['id' => $cita->id]) }}" method="post" class="p-4 md:p-5">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $cita->id }}" data-delete-route="{{ route('citas.destroy', ['id' => $cita->id]) }}">
                        <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="confirmar_eliminar">
                            Confirmar
                        </button>
                    </form>
                    <button type="button" class="h-10 text-gray-600 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" data-modal-toggle="confirm_delete_modal_{{ $cita->id }}" data-delete-route="{{ route('citas.destroy', ['id' => $cita->id]) }}">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- MODAL PARA CREAR CITAS -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Añadir Nueva Cita
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <form action="{{ route('citas.store') }}" id="crearForm" method="post" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="user_idCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Cliente</label>
                        <input type="text" name="user_id" id="user_idCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Introduzca el ID del cliente" required>
                    </div>
                    <div class="col-span-2">
                        <label for="peluquero_id_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peluquero</label>
                        <select name="peluquero_id" id="peluquero_id_crear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="fecha_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                        <input id="fecha_crear" name="fecha" type="date" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                    </div>
                    <div class="col-span-2">
                        <label for="hora_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
                        <select id="hora_crear" name="hora" class="mt-1 p-2 block w-full border border-gray-300 rounded-md cursor-not-allowed" required disabled>
                            <option value="">Selecciona una hora</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="servicio_crear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicio</label>
                        <select name="servicio" id="servicio_crear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p id="texto_cambio_crear" class="hidden text-red-500 text-xs italic mb-2">Has de realizar cambios para poder guardar</p>
                <p id="texto_hora_crear" class="hidden text-red-500 text-xs italic mb-2">No puedes hacer cambios a falta de menos de 24 horas para tu cita.</p>
                <button type="submit" id="submit_button_crear" class="text-black bg-gray-300 inline-flex items-center cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center" disabled>Añadir nueva cita</button>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT PARA VALIDAR LAS FECHAS -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function initializeModalScripts(modalId) {
            const fechaInput = document.getElementById('fecha_' + modalId);
            const peluqueroInput = document.getElementById('peluquero_id_' + modalId);
            const horaInput = document.getElementById('hora_' + modalId);
            const errorMessage = document.createElement('p');
            errorMessage.className = 'text-red-500 text-xs italic mb-2 mt-2';
            errorMessage.style.display = 'none';
            fechaInput.parentNode.insertBefore(errorMessage, fechaInput.nextSibling);

            const today = new Date().toISOString().split('T')[0];
            fechaInput.setAttribute('min', today);

            function disableHoraInput() {
                horaInput.disabled = true;
                horaInput.classList.add('cursor-not-allowed');
            }

            function enableHoraInput() {
                horaInput.disabled = false;
                horaInput.classList.remove('cursor-not-allowed');
            }

            function generateTimeOptions() {
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

            function getCurrentTime() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                return `${hours}:${minutes}:00`;
            }

            function validateDate() {
                const selectedDate = new Date(fechaInput.value);
                const day = selectedDate.getUTCDay();

                if (day === 0 || day === 6) {
                    fechaInput.value = '';
                    errorMessage.textContent = 'No se pueden seleccionar fines de semana. Por favor, elige otro día.';
                    errorMessage.style.display = 'block';
                    disableHoraInput();
                    return;
                } else if (fechaInput.value === '') {
                    errorMessage.textContent = 'Selecciona una fecha antes de elegir una hora';
                    errorMessage.style.display = 'block';
                    disableHoraInput();
                    return;
                }

                errorMessage.style.display = 'none';
                enableHoraInput();
                obtenerCitas(peluqueroInput.value, fechaInput.value);
            }

            function obtenerCitas(peluqueroId, fecha) {
                if (!peluqueroId || !fecha) {
                    horaInput.innerHTML = '<option value="" disabled selected>Selecciona una hora</option>';
                    return;
                }

                console.log('Obteniendo citas para peluquero:', peluqueroId, 'en la fecha:', fecha);


                fetch(`/admin/gestionar_citas/obtenerCitas?peluquero_id=${peluqueroId}&fecha=${fecha}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(citas => {
                        actualizarHorasDisponibles(citas, fecha);
                    })
                    .catch(error => {
                        console.error('Error obteniendo citas:', error);
                    });

            }

            function actualizarHorasDisponibles(citas, fecha) {
                horaInput.innerHTML = '<option value="" disabled selected>Selecciona una hora</option>';
                const occupiedTimes = citas
                    .filter(cita => cita.fecha === fecha)
                    .map(cita => `${cita.hora}`);
                const availableTimes = generateTimeOptions().filter(time => !occupiedTimes.includes(time));

                console.log('Horas ocupadas:', occupiedTimes);

                availableTimes.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time.slice(0, 5);
                    option.textContent = time.slice(0, 5);
                    horaInput.appendChild(option);
                });

                const today = new Date().toISOString().split('T')[0];
                if (fechaInput.value === today) {
                    const currentTime = getCurrentTime();
                    horaInput.querySelectorAll('option').forEach(option => {
                        if (option.value && option.value < currentTime.slice(0, 5)) {
                            option.disabled = true;
                        }
                    });
                }
            }

            peluqueroInput.addEventListener('change', function() {
                if (fechaInput.value) {
                    obtenerCitas(this.value, fechaInput.value);
                }
            });

            fechaInput.addEventListener('input', function() {
                validateDate();
            });

            if (!fechaInput.value) {
                disableHoraInput();
            }

            validateDate();
        }

        @foreach($citas as $cita)
        initializeModalScripts('edit_{{ $cita->id }}');
        @endforeach

        initializeModalScripts('crear');
    });
</script>

<!-- SCRIPT PARA FILTRAR Y PAGINAR POR AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var estado = $('#filtro-citas').val();
            fetchCitas(page, estado);
        });

        $('#filtro-citas').on('change', function() {
            var estado = $(this).val();
            fetchCitas(1, estado); // Reiniciar a la primera página al cambiar el filtro
        });

        function fetchCitas(page, estado) {
            $.ajax({
                url: "/admin/citas?page=" + page + "&estado=" + estado,
                success: function(data) {
                    $('#citas-content').html(data);
                }
            });
        }
    });
</script>

@endsection