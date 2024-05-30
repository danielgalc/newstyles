@extends('layouts.admin_layout')

@section('title', 'Lista de Usuarios')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Lista de Usuarios</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Crear usuario
        </button>
    </div>

    <!-- FILTRO POR ROLES -->
    <div class="mb-4 ">
        <form method="GET" action="{{ route('admin.usuarios') }}" id="filter-form">
            <select class="rounded" name="rol" id="filtro-users" onchange="document.getElementById('filter-form').submit();">
                <option value="" {{ request('rol') == '' ? 'selected' : '' }}>Mostrar todo</option>
                <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Clientes</option>
                <option value="peluquero" {{ request('rol') == 'peluquero' ? 'selected' : '' }}>Peluqueros</option>
            </select>
        </form>
    </div>

    <div id="usuarios-content">
        @include('admin.usuarios.partials.usuarios_list', ['usuarios' => $usuarios])
    </div>
</div>

<!-- MODAL PARA EDITAR USUARIOS -->
@foreach ($usuarios as $usuario)
<div id="edit_user_modal_{{ $usuario->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Usuario: <span class="italic text-teal-600">{{ $usuario->name }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_user_modal_{{ $usuario->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- Form Editar -->
            <form action="{{ route('users.update', ['id' => $usuario->id]) }}" id="editForm_{{ $usuario->id }}" data-edit-form method="post" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name_{{ $usuario->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="name" id="name_{{ $usuario->id }}" value="{{ $usuario->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div class="col-span-2">
                        <label for="email_{{ $usuario->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico</label>
                        <input type="email" name="email" id="email_{{ $usuario->id }}" value="{{ $usuario->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div class="col-span-2">
                        <label for="rol_{{ $usuario->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                        <select name="rol" id="rol_{{ $usuario->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="peluquero" {{ $usuario->rol == 'peluquero' }}>Peluquero</option>
                            <option value="admin" {{ $usuario->rol == 'admin' }}>Administrador</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Guardar cambios
                </button>

                <button type="button" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" data-modal-hide="edit_user_modal_{{ $usuario->id }}" data-modal-target="confirm_delete_modal_{{ $usuario->id }}" data-modal-toggle="confirm_delete_modal_{{ $usuario->id }}">
                    Eliminar usuario
                </button>
            </form>

        </div>
    </div>
</div>

<!-- MODAL PARA CONFIRMAR BORRADO DE USUARIOS -->
<div id="confirm_delete_modal_{{ $usuario->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirmar eliminación
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_delete_modal_{{ $usuario->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p>¿Estás seguro de que quieres eliminar este usuario? ID: {{ $usuario->id }}</p>
                <div class="flex justify-end items-center mt-4">
                    <form action="{{ route('users.destroy', ['id' => $usuario->id]) }}" method="post" class="p-4 md:p-5">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $usuario->id }}" data-delete-route="{{ route('users.destroy', ['id' => $usuario->id]) }}">
                        <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="confirmar_eliminar">
                            Confirmar
                        </button>
                    </form>

                    <button type="button" class="h-10 text-gray-600 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" data-modal-toggle="confirm_delete_modal_{{ $usuario->id }}" data-delete-route="{{ route('users.destroy', ['id' => $usuario->id]) }}">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach




<!-- MODAL PARA CREAR USUARIOS -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Crear Nuevo Usuario
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('users.store') }}" method="post" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 group">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="name" id="nameCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe el nombre del usuario" required>
                    </div>
                    <div class="col-span-2 group">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
                            Electrónico</label>
                        <input type="email" name="email" id="emailCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe el correo electrónico" required>
                    </div>
                    <div class="col-span-2 group">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                        <input type="password" name="password" id="passwordCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe la contraseña" required>
                    </div>
                    <div class="col-span-2">
                        <label for="rol" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                        <select name="rol" id="rol" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="cliente" selected>Cliente</option>
                            <option value="admin">Admin</option>
                            <option value="peluquero">Peluquero</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Añadir nuevo usuario
                </button>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT PARA FILTRAR Y PAGINAR POR AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var rol = $('#filtro-users').val();
            fetchUsuarios(page, rol);
        });

        $('#filtro-users').on('change', function() {
            var rol = $(this).val();
            fetchUsuarios(1, rol); // Reiniciar a la primera página al cambiar el filtro
        });

        function fetchUsuarios(page, rol) {
            $.ajax({
                url: "/admin/usuarios?page=" + page + "&rol=" + rol,
                success: function(data) {
                    $('#usuarios-content').html(data);
                }
            });
        }
    });
</script>


<!-- SCRIPTS PARA VALIDAR LA CREACIÓN Y MODIFICACION DE USUARIOS -->

<script>
    // VALIDACIÓN DE LOS FORMULARIOS DE CREAR Y EDITAR USUARIOS
    document.addEventListener('DOMContentLoaded', function() {
        const crearForm = document.querySelector('form[action="{{ route('users.store') }}"]');
        const editarForm = document.querySelector('form[action^="{{ route('users.update', '') }}"]');

        if (crearForm) {
            crearForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario
                validateForm(crearForm, 'nameCrear', 'emailCrear', 'passwordCrear');
            });
        }

        // Validación del formulario de edición
        document.querySelectorAll('[data-edit-form]').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario
                const id = form.id.split('_')[1];
                validateForm(event.target, `name_${id}`, `email_${id}`, `password_${id}`);
            });
        });

        function validateForm(form, nameId, emailId, passwordId) {
            const nameInput = document.getElementById(nameId);
            const emailInput = document.getElementById(emailId);
            const passwordInput = passwordId ? document.getElementById(passwordId) : null;
            let errors = false;

            // Validar el nombre
            if (nameInput.value.length < 3 || !nameInput.value) {
                showError(nameInput, 'Nombre no válido. Introduce un nombre válido.');
                errors = true;
            } else if (!validarInput(nameInput.value)) {
                showError(nameInput, 'Ni números ni símbolos especiales son válidos en este campo. Introduce un nombre válido, por favor.');
                errors = true;
            } else {
                hideError(nameInput);
            }

            // Validar el email
            if (!emailInput.value || !isValidEmail(emailInput.value)) {
                showError(emailInput, 'Por favor, introduce una dirección de correo electrónico válida');
                errors = true;
            } else {
                hideError(emailInput);
            }

            // Validar la contraseña (solo para crear)
            if (passwordInput) {
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (passwordInput.value.length < 8 || !passwordRegex.test(passwordInput.value)) {
                    showError(passwordInput, 'La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial.');
                    errors = true;
                } else {
                    hideError(passwordInput);
                }
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

        function isValidEmail(email) {
            // Expresión regular para validar email
            const emailRegex = /^[^\s@]{5,}@[^.\s@]{4,}\.[^.\s@]{2,}$/;
            return emailRegex.test(email);
        }

        function validarInput(input) {
            const regex = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
            return regex.test(input);
        }
    });
</script>

@endsection