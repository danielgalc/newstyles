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
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/servicios/create" style="background-color: greenyellow">Añadir servicio</a>

    </div>
</x-app-layout>