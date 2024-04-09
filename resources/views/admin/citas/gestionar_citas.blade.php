<!-- resources/views/admin/citas.blade.php -->

@extends('layouts.admin_layout')

@section('title', 'Gestionar Citas')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Listado de Citas</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Añadir nueva cita
        </button>
    </div>
    @if($citas->count() > 0)
        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peluquero</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($citas as $cita)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->peluquero->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->servicio }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->fecha }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->hora->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cita->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Mostrar enlaces de paginación -->
        {{ $citas->links() }}
    @else
        <p>No hay citas disponibles.</p>
    @endif
</div>

<!-- MODAL PARA CREAR CITAS -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
<div class="relative p-4 w-full max-w-md max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Añadir Nueva Cita
            </h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Cerrar modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <form action="{{ route('citas.store') }}" method="post" class="p-4 md:p-5">
            @csrf
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label for="id_cliente"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Cliente</label>
                    <input type="text" name="id_cliente" id="id_cliente"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Introduzca el ID del cliente" required>
                </div>
                <div class="col-span-2">
                    <label for="id_peluquero"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Peluquero</label>
                    <input type="text" name="id_peluquero" id="id_peluquero"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Introduzca el ID del peluquero" required>
                </div>
                <div class="col-span-2">
                    <label for="cita_servicio"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicio</label>
                    <select name="cita_servicio" id="cita_servicio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- TODO: FILTRADO DE HORAS SEGÚN DISPONIBILIDAD DEL PELUQUERO --}}
                <div class="col-span-2">
                    <label for="fecha"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                    <input id="fecha" name="fecha" type="date"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                </div>
                <div class="col-span-2">
                    <label for="hora"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
                    <input id="hora" name="hora" type="time"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Introduce la hora" required>
                </div>
            </div>
            {{-- TODO: AL CREAR UNA NUEVA CITA, SU ESTADO HA DE SER ACEPTADA AUTOMÁTICAMENTE --}}
            <button type="submit"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Añadir nuevo producto
            </button>
        </form>
    </div>
</div>
</div>

@endsection