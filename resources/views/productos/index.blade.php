<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold leading-tight ">
            {{ __('CATÁLOGO') }}
        </h1>
    </x-slot>

    <div class="container">
        <h2>Lista de Productos</h2>

        <!-- Formulario de filtros -->
        <div class="mb-4">
            <form action="{{ route('productos') }}" method="GET">
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


        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td><a href="/productos/{{ $producto->id }}/edit" style="background-color: aqua">Editar</a></td>
                        <td>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: red; border: none; color: white; padding: 5px 10px; cursor: pointer;">Borrar</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('add', $producto) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="px-4 py-1 text-sm text-white bg-orange-500 rounded">Añadir al carrito</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <a href="/productos/create" style="background-color: greenyellow">Crear producto</a>
</x-app-layout>
