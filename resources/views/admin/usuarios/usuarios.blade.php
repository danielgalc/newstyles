<!-- resources/views/admin/usuarios.blade.php -->
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

    @if ($usuarios->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="users-table">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Nombre
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Email
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Rol</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                    Verificado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Última
                    Modificación</th>
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
                    <td class="px-6 py-4 whitespace-nowraptext-center text-center">
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
    {{ $usuarios->links() }}
    @else
    <p>No hay usuarios disponibles.</p>
    @endif

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
            <form action="{{ route('users.update', ['id' => $usuario->id]) }}" id="editForm" method="post" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ $usuario->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
                            Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ $usuario->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>
                    <div class="col-span-2">
                        <label for="rol" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                        <select name="rol" id="rol" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente
                            </option>
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

<!-- SCRIPT PARA FILTRAR POR ROLES -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterSelect = document.getElementById('filtro-users');
    const tableRows = document.querySelectorAll('#users-table .user-row');

    filterSelect.addEventListener('change', function () {
        const filterValue = filterSelect.value;
        tableRows.forEach(row => {
            const rol = row.getAttribute('data-rol');
            if (filterValue === "" || rol === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>

<!-- SCRIPTS PARA VALIDAR LA CREACIÓN Y MODIFICACION DE USUARIOS -->

<script>
    // VALIDACIÓN DEL FORMULARIO DE CREAR
    const crearForm = document.getElementById('crearForm');
    crearForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        const nameInput = document.getElementById('nameCrear');
        const emailInput = document.getElementById('emailCrear');
        const passwordInput = document.getElementById('passwordCrear');
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

        // Validar la contraseña
        if (passwordInput.value.length < 8) {
            showError(passwordInput, 'La contraseña debe tener al menos 8 caracteres.');
            errors = true;
        } else {
            hideError(passwordInput);
        }

        if (!errors) {
            crearForm.submit(); // Enviar el formulario si no hay errores
        }
    });

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
        const regex = /^[a-zA-Z\s]+$/;
        return regex.test(input);
    }
</script>

<script>
    // VALIDACIÓN DEL FORMULARIO DE EDITAR
    const editarForm = document.getElementById('editForm');
    editarForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
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

        if (!errors) {
            editarForm.submit(); // Enviar el formulario si no hay errores
        }
    });

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
        const regex = /^[a-zA-Z\s]+$/;
        return regex.test(input);
    }
</script>



@endsection

