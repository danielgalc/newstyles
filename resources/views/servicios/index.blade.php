<x-app-layout>
        <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md"> 
            <h2 class="font-righteous text-4xl text-gray-800 leading-tight">
                {{ __('Listado de servicios')}}
            </h2>
        </div>

    <div class="container mx-auto">
        <h2>Lista de Servicios</h2>

        <!-- Formulario de filtros -->
        <div class="mb-4">
            <form action="{{ route('servicios') }}" method="GET">
                <label for="ordenar">Ordenar por:</label>
                <select name="ordenar" id="ordenar">
                    <option value="nombre_asc" {{ request('ordenar') == 'nombre_asc' ? 'selected' : '' }}>Nombre (ascendente)</option>
                    <option value="nombre_desc" {{ request('ordenar') == 'nombre_desc' ? 'selected' : '' }}>Nombre (descendente)</option>
                    <option value="precio_asc" {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}>Precio (ascendente)</option>
                    <option value="precio_desc" {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}>Precio (descendente)</option>
                </select>

                <label for="buscar">Buscar:</label>
                <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}">

                <button type="submit">Filtrar</button>
            </form>
        </div>
        {{-- <div class="mt-4">
            <a href="/servicios/{{ $servicio->id }}/edit" class="bg-blue-500 text-white py-2 px-4 rounded">Editar</a>
            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este servicio?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded" style="margin-left: 4px;">Borrar</button>
            </form>
        </div> --}}

        <div class="grid grid-cols-2 gap-x-24 gap-y-12">
            @foreach($serviciosPrincipales as $index => $servicio)
                <div class="relative h-32 p-6 shadow-md rounded-md {{ $index % 4 == 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                    <h3 class="text-3xl font-semibold mb-3">{{ $servicio->nombre }}</h3>
            
                    <div class="absolute bottom-0 right-0 h-full w-1/4 flex flex-col items-center justify-center p-4">
                        <p class="text-3xl">{{ $servicio->precio }} &euro;</p>
                        <p class="text-lg text-gray-600">Aprox. {{ $servicio->duracion }}</p>
                        <a href="/citas/{{ $servicio->id }}/create" class="bg-teal-400 text-white font-bold text-2xl w-full h-12 text-center rounded-full mt-2">Reservar</a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <p id="otrosServiciosToggle" class="cursor-pointer text-blue-500 underline mt-4">
            Otros Servicios
        </p>
        
        <div id="otrosServiciosContainer" class="hidden mt-4 w-full">
            @if ($serviciosSecundarios->count() > 0)
                <p>Servicios secundarios encontrados.</p>
                <div class="grid grid-cols-2 gap-x-24 gap-y-12">
                    @foreach($serviciosSecundarios as $index => $servicio)
                    <div class="relative h-32 p-6 shadow-md rounded-md {{ $index % 4 == 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                        <h3 class="text-3xl font-semibold mb-3">{{ $servicio->nombre }}</h3>
            
                        <div class="absolute bottom-0 right-0 h-full w-1/4 flex flex-col items-center justify-center p-4">
                            <p class="text-3xl">{{ $servicio->precio }} &euro;</p>
                            <p class="text-lg text-gray-600">Aprox. {{ $servicio->duracion }}</p>
                            <a href="/citas/{{ $servicio->id }}/create" class="bg-teal-400 text-white font-bold text-2xl w-full h-12 text-center rounded-full mt-2">Reservar</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p>No hay servicios secundarios encontrados.</p>
            @endif
        </div>

        
        
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("jQuery loaded successfully.");
        $("#otrosServiciosToggle").click(function() {
            console.log("Toggle clicked.");
            $("#otrosServiciosContainer").slideToggle();
        });
    });
</script>

    {{-- <a href="/servicios/create" style="background-color: greenyellow">Añadir servicio</a> --}}
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