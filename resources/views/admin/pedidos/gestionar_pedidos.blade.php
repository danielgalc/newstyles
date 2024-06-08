@extends('layouts.admin_layout')

@section('title', 'Gestionar Pedidos')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Gestionar Pedidos</h2>
    </div>

    <!-- FILTRO POR ESTADO Y BÚSQUEDA -->
    <div class="mb-4 flex items-center">
        <form method="GET" action="{{ route('admin.pedidos') }}" id="filter-form" class="flex items-center">
            <select class="rounded mr-2" name="estado" id="filtro-pedidos" onchange="document.getElementById('filter-form').submit();">
                <option value="" {{ request('estado') == '' ? 'selected' : '' }}>Mostrar todo</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
            </select>
            <input type="text" name="buscar" placeholder="Buscar pedidos..." class="rounded border-gray-300 mr-2" value="{{ request('buscar') }}">
            <button type="submit" class="ml-2 text-white bg-teal-500 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-4 h-10 text-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800">Buscar</button>
        </form>
    </div>

    <div id="pedidos-content">
        @include('admin.pedidos.partials.pedidos_list', ['pedidos' => $pedidos])
    </div>
</div>

<!-- MODAL PARA VER PRODUCTOS DEL PEDIDO -->
@foreach ($pedidos as $pedido)
<div id="productos_pedido_modal_{{ $pedido->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Productos del Pedido: <span class="italic text-teal-400">{{ $pedido->transaccion }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="productos_pedido_modal_{{ $pedido->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 dark:text-white">
                <ul>
                    @foreach ($pedido->productos as $producto)
                        <li>{{ $producto['nombre'] }} - Cantidad: {{ $producto['cantidad'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL PARA EDITAR PEDIDOS -->
@foreach ($pedidos as $pedido)
<div id="edit_pedido_modal_{{ $pedido->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Editar Pedido: <span class="italic text-teal-600">{{ $pedido->id }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit_pedido_modal_{{ $pedido->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- Form Editar -->
            <form action="{{ route('pedidos.update', ['id' => $pedido->id]) }}" id="editForm_{{ $pedido->id }}" method="post" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="estado_{{ $pedido->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <select name="estado" id="estado_{{ $pedido->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            <option value="pendiente" {{ $pedido->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aceptado" {{ $pedido->estado == 'Aceptado' ? 'selected' : '' }}>Aceptado</option>
                            <option value="enviado" {{ $pedido->estado == 'Enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="cancelado" {{ $pedido->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-teal-500 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800">
                    Guardar cambios
                </button>

                <button type="button" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" data-modal-hide="edit_pedido_modal_{{ $pedido->id }}" data-modal-target="confirm_delete_modal_{{ $pedido->id }}" data-modal-toggle="confirm_delete_modal_{{ $pedido->id }}">
                    Eliminar pedido
                </button>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL PARA CONFIRMAR BORRADO DE PEDIDOS -->
@foreach ($pedidos as $pedido)
<div id="confirm_delete_modal_{{ $pedido->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Confirmar eliminación
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="confirm_delete_modal_{{ $pedido->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 dark:text-white">
                <p>¿Estás seguro de que quieres eliminar este pedido? ID: {{ $pedido->id }}</p>
                <div class="flex justify-end items-center mt-4">
                    <form action="{{ route('pedidos.destroy', ['id' => $pedido->id]) }}" method="post" class="p-4 md:p-5">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $pedido->id }}" data-delete-route="{{ route('pedidos.destroy', ['id' => $pedido->id]) }}">
                        <button type="submit" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Confirmar
                        </button>
                    </form>
                    <button type="button" class="h-10 text-black border border-red-400 bg-white hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-white dark:hover:bg-gray-300 dark:focus:ring-red-800" data-modal-toggle="confirm_delete_modal_{{ $pedido->id }}">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

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
            var estado = $('#filtro-pedidos').val();
            var buscar = $('input[name="buscar"]').val();
            fetchPedidos(page, estado, buscar);
        });

        $('#filtro-pedidos').on('change', function() {
            $('#filter-form').submit();
        });

        function fetchPedidos(page, estado, buscar) {
            $.ajax({
                url: "/admin/pedidos?page=" + page + "&estado=" + estado + "&buscar=" + buscar,
                success: function(data) {
                    $('#pedidos-content').html(data);
                }
            });
        }
    });
</script>

@endsection
