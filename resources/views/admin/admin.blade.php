@extends('layouts.admin_layout')

@section('title', 'Dashboard')

@section('content')
    <div id="content-container">
        <h1 class="text-6xl font-bold mb-4">Bienvenido, {{ auth()->user()->name }}</h1>

        <!-- Agrega las tablas aquí -->
        <div class="user-preview-container grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-4">
            <!-- Primera tabla -->
            <div class="user-preview px-3 py-2 rounded-lg border border-gray-300 overflow-y-auto h-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-4xl font-bold">Usuarios</h2>
                        <h5 class="text-md font-extralight">Últimos usuarios añadidos</h5>
                    </div>
                    <div class="pb-10">
                        <a href="{{ route('admin.usuarios') }}" class="text-blue-700 hover:underline">Ver todos los usuarios</a>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="users-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verificado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Modificación</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->rol }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($usuario->email_verified_at)
                                        Sí
                                    @else
                                        No
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Segunda tabla -->
            <div class="citas-preview px-3 py-2 rounded-lg border border-gray-300 overflow-y-auto h-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-4xl font-bold">Citas</h2>
                        <h5 class="text-md font-extralight">Últimas citas añadidos</h5>
                    </div>
                    <div class="pb-10">
                        <a href="{{ route('admin.citas') }}" class="text-blue-700 hover:underline">Gestionar todas los citas</a>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="citas-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peluquero</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Modificación</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($citas as $cita)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->peluquero->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->servicio }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->fecha }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->hora->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->estado }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cita->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>
            </div>

            <!-- Tercera tabla -->
            <div class="user-preview px-3 py-2 rounded-lg border border-gray-300 overflow-y-auto h-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-4xl font-bold">Servicios</h2>
                        <h5 class="text-md font-extralight">Últimos servicios agregados</h5>
                    </div>
                    <div class="pb-10">
                        <a href="{{ route('admin.servicios') }}" class="text-blue-700 hover:underline">Ver todos los servicios</a>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="users-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de creación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última modificación</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($servicios as $servicio)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->precio }} &euro;</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->duracion }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($servicio->clase == 'principal')
                                        Principal
                                    @else
                                        Secundario
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->created_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $servicio->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cuarta tabla -->
            <div class="user-preview px-3 py-2 rounded-lg border border-gray-300 overflow-y-auto h-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-4xl font-bold">Productos</h2>
                        <h5 class="text-md font-extralight">Últimos productos añadidos al catálogo</h5>
                    </div>
                    <div class="pb-10">
                        <a href="{{ route('admin.productos') }}" class="text-blue-700 hover:underline">Ver todos los productos</a>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="users-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de creación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última modificación</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($productos as $producto)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($producto->descripcion, 20, '...') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->precio }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->stock }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->created_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Quinta tabla -->
            <div class="user-preview px-3 py-2 rounded-lg border border-gray-300 overflow-y-auto h-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-4xl font-bold">Gestion de Horas</h2>
                        <h5 class="text-md font-extralight">Horas bloqueadas por los peluqueros</h5>
                    </div>
                    <div class="pb-10">
                        <a href="{{ route('admin.bloqueos') }}" class="text-blue-700 hover:underline">Ver todas las horas bloqueadas</a>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="bloqueos-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peluquero</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas Bloqueadas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bloqueos as $bloqueo)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $bloqueo->peluquero->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $bloqueo->fecha }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ implode(', ', $bloqueo->horas) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
