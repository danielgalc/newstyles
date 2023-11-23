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
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->precio }}</td>
                        <td>{{ $servicio->duracion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/servicios/create" style="background-color: greenyellow">Añadir servicio</a>

    </div>
</x-app-layout>