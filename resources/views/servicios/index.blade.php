<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold leading-tight ">
            {{ __('CATÁLOGO') }}
        </h1>

    </x-slot>

    <div class="container">
        <h2>Lista de Servicios</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Duracion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->precio }}</td>
                        <td>{{ $servicio->duracion }}</td>
                        <td><a href="/servicios/{{ $servicio->id }}/edit" style="background-color: aqua">Editar</a></td>
                        <td>
                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este servicio?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: red; border: none; color: white; padding: 5px 10px; cursor: pointer;">Borrar</button>
                            </form>
                        </td>
                        <td>
                            <a href="/citas/{{ $servicio->id }}/create" style="background-color: orange">Reservar</a>
                        </td>
                        {{-- <td>
                            <button id="openModalBtn" class="bg-blue-500 text-white py-2 px-4 rounded">Reservar</button>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/servicios/create" style="background-color: greenyellow">Añadir servicio</a>

    </div>
{{-- 
<!-- Modal -->
<div id="reservarModal" class="fixed inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded p-8">
            <!-- Contenido del modal -->
            
            <h2 class="text-2xl font-bold mb-4">Reservar Cita</h2>

            <form action="{{route('citas.store')}}" method="POST" enctype="multipart/form-data" id="reservarForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">

                <!-- En tu vista servicios.index, justo antes del select -->
                @dump($peluqueros)    

                <!-- Selección de peluquero -->
                <label for="peluquero_id" class="block text-sm font-medium text-gray-700">Peluquero</label>
                <select name="peluquero_id" id="peluquero_id" class="mt-1 block w-full p-2 border rounded-md">
                    <!-- Aquí puedes iterar sobre los peluqueros disponibles y crear opciones -->
                    @foreach($peluqueros as $peluquero)
                        <option value="{{ $peluquero->id }}">{{ $peluquero->name }}</option>
                    @endforeach
                </select>
            
                <!-- Selección de fecha -->
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="mt-1 block w-full p-2 border rounded-md">
            
                <!-- Selección de hora -->
                <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
                <input type="time" name="hora" id="hora" class="mt-1 block w-full p-2 border rounded-md">

                <!-- Selección de hora -->
                <p>Servicio: {{ $servicio->nombre }}</p>
                <p>Servicio ID: {{ $servicio->id }}</p>
                <p>Usuario ID: {{ auth()->user()->id }}</p>
                <p>Usuario Nombre: {{ auth()->user()->name }}</p>

                <div class="flex justify-end mt-4">
                    <button id="closeModalBtn" class="bg-gray-400 text-white py-2 px-4 rounded mr-2">Cancelar</button>
                    <button type="submit" id="reservarBtn" class="bg-blue-500 text-white py-2 px-4 rounded">Reservar</button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- Script para abrir y cerrar el modal con JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var openModalBtn = document.getElementById('openModalBtn');
    var closeModalBtn = document.getElementById('closeModalBtn');
    var modal = document.getElementById('reservarModal');
    var reservarBtn = document.getElementById('reservarBtn');

    openModalBtn.addEventListener('click', function () {
        modal.classList.remove('hidden');
    });

    closeModalBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });


});

</script> --}}

</x-app-layout>