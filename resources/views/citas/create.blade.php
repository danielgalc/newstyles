<h1>Seleccione su cita</h1>
<form action="{{route ('citas.store') }}" method="POST" enctype="multipart/form-data">
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

                <p>{{dump($servicio)}}</p>
                <p>{{dump(Auth::user()->id)}}</p>

                <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">

                <a href="/servicios"><button type="submit">Añadir cita</button></a>
</form>