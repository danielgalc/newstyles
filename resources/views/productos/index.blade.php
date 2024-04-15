<x-app-layout>
    <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
        <h2 class="font-righteous text-4xl text-gray-800 leading-tight">
            {{ __('Catálogo de productos ')}}
        </h2>
    </div>
    <div class="container mx-auto">
        <!-- Formulario de filtros -->
        <div class="my-4 flex">
            <!-- Select -->
            <form action="{{ route('productos') }}" method="GET" class="mr-4">
                <select name="ordenar" id="ordenar" class="w-44 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="nombre_asc" {{ request('ordenar') == 'nombre_asc' ? 'selected' : '' }}>Nombre (ascendente)</option>
                    <option value="nombre_desc" {{ request('ordenar') == 'nombre_desc' ? 'selected' : '' }}>Nombre (descendente)</option>
                    <option value="precio_asc" {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}>Precio (ascendente)</option>
                    <option value="precio_desc" {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}>Precio (descendente)</option>
                </select>
            </form>

            <!-- Search -->
            <form action="{{ route('productos') }}" method="GET">
                <div class="relative">
                    <input type="search" name="buscar" id="buscar" value="{{ request('buscar') }}" class="w-96 p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar productos..." required />
                    <button type="submit" class="absolute inset-y-0 right-0 px-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                </div>
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
</x-app-layout>