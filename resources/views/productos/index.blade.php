<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold leading-tight ">
            {{ __('CATÁLOGO') }}
        </h1>
    </x-slot>

    <div class="container">
        <h2>Lista de Productos</h2>

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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <a href="/productos/create" style="background-color: greenyellow">Crear producto</a>
</x-app-layout>
