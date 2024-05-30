@extends('layouts.admin_layout')

@section('title', 'Lista de Servicios')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Gestionar de Servicios</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Añadir nuevo servicio
        </button>
    </div>

    <!-- FILTRO POR CLASE -->
    <div class="mb-4">
        <form method="GET" action="{{ route('admin.servicios') }}" id="filter-form">
            <select class="rounded" name="clase" id="filtro-servicios" onchange="document.getElementById('filter-form').submit();">
                <option value="" {{ request('clase') == '' ? 'selected' : '' }}>Mostrar todo</option>
                <option value="principal" {{ request('clase') == 'principal' ? 'selected' : '' }}>Principal</option>
                <option value="secundario" {{ request('clase') == 'secundario' ? 'selected' : '' }}>Secundario</option>
            </select>
        </form>
    </div>

    <div id="servicios-content">
        @include('admin.servicios.partials.servicios_list', ['servicios' => $servicios])
    </div>
</div>

<!-- MODAL PARA EDITAR SERVICIOS -->
@foreach ($servicios as $servicio)
<div id="edit_servicio_modal_{{ $servicio->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Servicio: <span class="italic text-teal-600">{{ $servicio->nombre }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_servicio_modal_{{ $servicio->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- Form Editar -->
            <form action="{{ route('servicios.update', ['id' => $servicio->id]) }}" id="editForm_{{ $servicio->id }}" data-edit-form method="post" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="nombre_{{ $servicio->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="nombre" id="nombre_{{ $servicio->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $servicio->nombre }}" required>
                    </div>
                    <div class="col-span-2">
                        <label for="precio_{{ $servicio->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                        <input type="number" name="precio" id="precio_{{ $servicio->id }}" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $servicio->precio }}" placeholder="0.00 €" step="0.01" required>
                    </div>
                    <div class="col-span-2">
                        <label for="duracion_{{ $servicio->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duración (en minutos)</label>
                        <input type="number" name="duracion" id="duracion_{{ $servicio->id }}" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $servicio->duracion }}" placeholder="Escribe la duración del servicio" required>
                    </div>
                    <div class="col-span-2">
                        <label for="clase_{{ $servicio->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Clase</label>
                        <select name="clase" id="clase_{{ $servicio->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="principal" {{ $servicio->clase == 'principal' ? 'selected' : '' }}>Principal</option>
                            <option value="secundario" {{ $servicio->clase == 'secundario' ? 'selected' : '' }}>Secundario</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Guardar cambios
                </button>

                <button type="button" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" data-modal-hide="edit_servicio_modal_{{ $servicio->id }}" data-modal-target="confirm_delete_modal_{{ $servicio->id }}" data-modal-toggle="confirm_delete_modal_{{ $servicio->id }}">
                    Eliminar servicio
                </button>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA CONFIRMAR BORRADO DE SERVICIOS -->
<div id="confirm_delete_modal_{{ $servicio->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirmar eliminación
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_delete_modal_{{ $servicio->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p class="text-white">¿Estás seguro de que quieres eliminar el servicio: <span class="italic text-teal-400">{{$servicio->nombre}}</span>?</p>
                <div class="flex justify-end items-center mt-4">
                    <form action="{{ route('servicios.destroy', ['id' => $servicio->id]) }}" method="post" class="p-4 md:p-5">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $servicio->id }}" data-delete-route="{{ route('servicios.destroy', ['id' => $servicio->id]) }}">
                        <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="confirmar_eliminar">
                            Confirmar
                        </button>
                    </form>

                    <button type="button" class="h-10 text-gray-100 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" data-modal-toggle="confirm_delete_modal_{{ $servicio->id }}" data-delete-route="{{ route('servicios.destroy', ['id' => $servicio->id]) }}">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL PARA CREAR SERVICIOS -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Añadir Nuevo Servicio
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('servicios.store') }}" id="crearForm" method="post" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="nombreCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del servicio</label>
                        <input type="text" name="nombre" id="nombreCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe el nombre del servicio" required>
                    </div>
                    <div class="col-span-2">
                        <label for="precioCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                        <input type="number" name="precio" id="precioCrear" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0.00 €" step="0.01" required>
                    </div>
                    <div class="col-span-2">
                        <label for="duracionCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duración (en minutos)</label>
                        <input type="number" name="duracion" id="duracionCrear" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe la duración del servicio" required>
                    </div>
                    <div class="col-span-2">
                        <label for="claseCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Clase</label>
                        <select name="clase" id="claseCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="principal" selected>Principal</option>
                            <option value="secundario">Secundario</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Añadir nuevo servicio
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ESTILO PARA OCULTAR LOS BOTONES DE LOS INPUTS NUMERICOS -->
<style>
    /* Ocultar los controles de número en Chrome, Safari, Edge y Opera */
    .number-input::-webkit-outer-spin-button,
    .number-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    /* Ocultar los controles de número en Firefox */
    .number-input[type=number] {
        -moz-appearance: textfield;
    }
    </style>

<!-- SCRIPT PARA FILTRAR Y PAGINAR POR AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var clase = $('#filtro-servicios').val();
            fetchServicios(page, clase);
        });

        $('#filtro-servicios').on('change', function() {
            var clase = $(this).val();
            fetchServicios(1, clase); // Reiniciar a la primera página al cambiar el filtro
        });

        function fetchServicios(page, clase) {
            $.ajax({
                url: "/admin/servicios?page=" + page + "&clase=" + clase,
                success: function(data) {
                    $('#servicios-content').html(data);
                }
            });
        }
    });
</script>

<!-- SCRIPTS PARA VALIDAR LA CREACIÓN Y MODIFICACION DE SERVICIOS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario de creación
        document.getElementById('crearForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario
            validateForm(event.target, 'nombreCrear', 'precioCrear', 'duracionCrear');
        });

        // Validación del formulario de edición
        document.querySelectorAll('[data-edit-form]').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario
                const id = form.id.split('_')[1];
                validateForm(event.target, `nombre_${id}`, `precio_${id}`, `duracion_${id}`);
            });
        });

        function validateForm(form, nombreId, precioId, duracionId) {
            const nombreInput = document.getElementById(nombreId);
            const precioInput = document.getElementById(precioId);
            const duracionInput = document.getElementById(duracionId);
            let errors = false;

            // Validar el nombre
            if (nombreInput.value.length < 3 || !nombreInput.value) {
                showError(nombreInput, 'Nombre no válido. Introduce un nombre válido.');
                errors = true;
            } else if (!validarInput(nombreInput.value)) {
                showError(nombreInput, 'Ni números ni símbolos especiales son válidos en este campo. Introduce un nombre válido, por favor.');
                errors = true;
            } else {
                hideError(nombreInput);
            }

            // Validar el precio
            if (!precioInput.value || precioInput.value <= 0) {
                showError(precioInput, 'Por favor, introduce un precio válido');
                errors = true;
            } else {
                hideError(precioInput);
            }

            // Validar la duración
            if (!duracionInput.value ||
                !Number.isInteger(Number(duracionInput.value)) ||
                duracionInput.value < 15 ||
                duracionInput.value > 60) {
                showError(duracionInput, 'Por favor, introduce una duración válida (entero positivo entre 15 y 60).');
                errors = true;
            } else {
                hideError(duracionInput);
            }


            if (!errors) {
                form.submit(); // Enviar el formulario si no hay errores
            }
        }

        function showError(input, message) {
            // Eliminar mensaje de error anterior si existe
            const previousError = input.parentNode.querySelector('.help-block');
            if (previousError) {
                previousError.parentNode.removeChild(previousError);
            }

            const errorSpan = document.createElement('span');
            errorSpan.classList.add('help-block', 'text-red-500', 'text-sm');
            errorSpan.innerText = message;

            input.parentNode.appendChild(errorSpan);

            input.classList.add('border', 'border-red-500');
        }

        function hideError(input) {
            const errorSpan = input.parentNode.querySelector('.help-block');

            if (errorSpan) {
                errorSpan.parentNode.removeChild(errorSpan);
            }

            input.classList.remove('border', 'border-red-500');
        }

        function validarInput(input) {
            const regex = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
            return regex.test(input);
        }
    });
</script>

@endsection