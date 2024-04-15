<x-app-layout>
        <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md"> 
            <h2 class="font-righteous text-4xl text-gray-800 leading-tight">
                {{ __('Catálogo de productos ')}}
            </h2>
        </div>
    <div class="container mx-auto">
        <h2>Lista de Productos</h2>

        <!-- Formulario de filtros -->
        <div class="mb-4">
            <form action="{{ route('productos') }}" method="GET">
                <label for="ordenar">Ordenar por:</label>
                <select name="ordenar" id="ordenar">
                    <option value="nombre_asc {{ request('ordenar') == 'nombre_asc' ? 'selected' : '' }}">Nombre (ascendente)</option>
                    <option value="nombre_desc {{ request('ordenar') == 'nombre_desc' ? 'selected' : '' }}">Nombre (descendente)</option>
                    <option value="precio_asc {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}">Precio (ascendente)</option>
                    <option value="precio_desc {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}">Precio (descendente)</option>
                </select>

                <label for="buscar">Buscar:</label>
                <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}">

                <button type="submit">Filtrar</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($productos as $producto)
                <div class="bg-white p-4 rounded-md shadow-md transition-all duration-300 ease-in-out transform hover:shadow-lg hover:bg-gray-900 hover:text-white hover:scale-105">
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-32 object-cover mb-2 rounded-md">
                    
                    <div class="text-container">
                        <h3 class="text-lg font-semibold">{{ $producto->nombre }}</h3>
                        <p class="text-gray-400">{{ $producto->descripcion }}</p>
                        <p class="text-lg font-bold text-teal-600">{{ $producto->precio }}&euro;</p>
                    </div>
                    
                    <form action="{{ route('add', $producto) }}" method="POST">
                        @csrf
                        <button type="submit" class="mt-2 px-4 py-2 text-sm text-white bg-teal-500 rounded">Añadir al carrito</button>
                    </form>
                </div>
            @endforeach
        </div>        

        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
    
    <a href="/productos/create" style="background-color: greenyellow">Crear producto</a>
</x-app-layout>



