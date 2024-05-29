<!-- resources/views/admin/lista_productos.blade.php -->
@extends('layouts.admin_layout')

@section('title', 'Lista de Productos')

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Gestionar Productos</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Añadir nuevo producto
        </button>
    </div>

    <!-- FILTRO POR CATEGORIA -->
    <div class="mb-4">
        <form method="GET" action="{{ route('admin.productos') }}" id="filter-form">
            <select class="rounded" name="categoria" id="filtro-productos" onchange="document.getElementById('filter-form').submit();">
                <option value="" {{ request('categoria') == '' ? 'selected' : '' }}>Mostrar todo</option>
                <option value="categoria1" {{ request('categoria') == 'categoria1' ? 'selected' : '' }}>Categoría 1</option>
                <option value="categoria2" {{ request('categoria') == 'categoria2' ? 'selected' : '' }}>Categoría 2</option>
            </select>
        </form>
    </div>

    @if ($productos->count() > 0)
    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="productos-table">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Nombre
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                    Descripción</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Precio
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Imagen
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Stock
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Categoría
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                    Actualizado en</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($productos as $producto)
            <tr class="hover:bg-teal-200 cursor-pointer w-full producto-row" data-categoria="{{ $producto->categoria }}" data-modal-toggle="edit_producto_modal_{{ $producto->id }}" data-modal-target="edit_producto_modal_{{ $producto->id }}">
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->nombre }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ Str::limit($producto->descripcion, $limit = 20, $end = '...') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->precio }} &euro;</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->imagen }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->stock }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->categoria }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $producto->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    {{ $productos->links() }}

    @else
    <p>No hay productos disponibles.</p>
    @endif
</div>

<!-- MODAL PARA EDITAR PRODUCTOS -->
@foreach ($productos as $producto)
<div id="edit_producto_modal_{{ $producto->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar: <span class="italic text-teal-600">{{ $producto->nombre }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_producto_modal_{{ $producto->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- Form Editar -->
            <form action="{{ route('productos.update', ['id' => $producto->id]) }}" id="editForm_{{ $producto->id }}" data-edit-form method="post" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="nombre_{{ $producto->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" name="nombre" id="nombre_{{ $producto->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $producto->nombre }}" required>
                    </div>
                    <div class="col-span-2">
                        <label for="descripcion_{{ $producto->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción del producto</label>
                        <textarea name="descripcion" id="descripcion_{{ $producto->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Describe las características del producto" required>{{ $producto->descripcion }}</textarea>
                    </div>
                    <div class="col-span-2">
                        <label for="precio_{{ $producto->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                        <input type="number" name="precio" id="precio_{{ $producto->id }}" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $producto->precio }}" placeholder="0.00 €" step="0.01" required>
                    </div>
                    <div class="col-span-2">
                        <label for="imagen_{{ $producto->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen</label>
                        <input id="imagen_{{ $producto->id }}" name="imagen" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    </div>
                    <div class="col-span-2">
                        <label for="stock_{{ $producto->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                        <input type="number" name="stock" id="stock_{{ $producto->id }}" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $producto->stock }}" placeholder="Añade el valor del stock del producto" step="1" required>
                    </div>
                    <div class="col-span-2">
                        <label for="categoria_{{ $producto->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría</label>
                        <select name="categoria" id="categoria_{{ $producto->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="categoria1" {{ $producto->categoria == 'categoria1' ? 'selected' : '' }}>Categoría 1</option>
                            <option value="categoria2" {{ $producto->categoria == 'categoria2' ? 'selected' : '' }}>Categoría 2</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Guardar cambios
                </button>

                <button type="button" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" data-modal-hide="edit_producto_modal_{{ $producto->id }}" data-modal-target="confirm_delete_modal_{{ $producto->id }}" data-modal-toggle="confirm_delete_modal_{{ $producto->id }}">
                    Eliminar producto
                </button>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA CONFIRMAR BORRADO DE PRODUCTOS -->
<div id="confirm_delete_modal_{{ $producto->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirmar eliminación
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_delete_modal_{{ $producto->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 dark:text-white">
                <p>¿Estás seguro de que quieres eliminar este producto? ID: {{ $producto->id }}</p>
                <div class="flex justify-end items-center mt-4">
                    <form action="{{ route('productos.destroy', ['id' => $producto->id]) }}" method="post" class="p-4 md:p-5">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $producto->id }}" data-delete-route="{{ route('productos.destroy', ['id' => $producto->id]) }}">
                        <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="confirmar_eliminar">
                            Confirmar
                        </button>
                    </form>

                    <button type="button" class="h-10 text-black border border-red-400 bg-white hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-white dark:hover:bg-gray-300 dark:focus:ring-red-800" data-modal-toggle="confirm_delete_modal_{{ $producto->id }}" data-delete-route="{{ route('productos.destroy', ['id' => $producto->id]) }}">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL PARA CREAR PRODUCTOS -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Añadir Nuevo Producto
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('productos.store') }}" id="crearForm" method="post" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="nombreCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del producto</label>
                        <input type="text" name="nombre" id="nombreCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe el nombre del producto" required>
                    </div>
                    <div class="col-span-2">
                        <label for="descripcionCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción del producto</label>
                        <textarea name="descripcion" id="descripcionCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Describe las características del producto" required></textarea>
                    </div>
                    <div class="col-span-2">
                        <label for="precioCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                        <input type="number" name="precio" id="precioCrear" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0.00 €" step="0.01" required>
                    </div>
                    <div class="col-span-2">
                        <label for="imagenCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen</label>
                        <input id="imagenCrear" name="imagen" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    </div>
                    <div class="col-span-2">
                        <label for="stockCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                        <input type="number" name="stock" id="stockCrear" class="number-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Añade el valor del stock del producto" step="1" required>
                    </div>
                    <div class="col-span-2">
                        <label for="categoriaCrear" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría</label>
                        <select name="categoria" id="categoriaCrear" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="categoria1">Categoría 1</option>
                            <option value="categoria2">Categoría 2</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Añadir nuevo producto
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

<!-- SCRIPT PARA FILTRAR POR CATEGORIA -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filtro-productos');
        const tableRows = document.querySelectorAll('#productos-table .producto-row');

        filterSelect.addEventListener('change', function() {
            const filterValue = filterSelect.value;
            tableRows.forEach(row => {
                const categoria = row.getAttribute('data-categoria');
                if (filterValue === "" || categoria === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<!-- SCRIPTS PARA VALIDAR LA CREACIÓN Y MODIFICACION DE PRODUCTOS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario de creación
        document.getElementById('crearForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario
            validateForm(event.target, 'nombreCrear', 'precioCrear', 'descripcionCrear', 'stockCrear', 'categoriaCrear');
        });

        // Validación del formulario de edición
        document.querySelectorAll('[data-edit-form]').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario
                const id = form.id.split('_')[1];
                validateForm(event.target, `nombre_${id}`, `precio_${id}`, `descripcion_${id}`, `stock_${id}`);
            });
        });

        function validateForm(form, nombreId, precioId, descripcionId, stockId, categoriaId) {
            const nombreInput = document.getElementById(nombreId);
            const precioInput = document.getElementById(precioId);
            const descripcionInput = document.getElementById(descripcionId);
            const stockInput = document.getElementById(stockId);
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

            // Validar la descripción
            if (descripcionInput.value.length < 5 || !descripcionInput.value) {
                showError(descripcionInput, 'Descripción no válida. Introduce una descripción válida.');
                errors = true;
            } else {
                hideError(descripcionInput);
            }

            // Validar el stock
            if (!stockInput.value || stockInput.value < 0) {
                showError(stockInput, 'Por favor, introduce una cantidad de stock válida');
                errors = true;
            } else {
                hideError(stockInput);
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
