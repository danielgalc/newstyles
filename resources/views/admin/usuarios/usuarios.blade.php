<!-- resources/views/admin/usuarios.blade.php -->
@extends('layouts.admin_layout')

@section('title', 'Lista de Usuarios')

@section('content')

<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Usuarios</h2>
    @if($usuarios->count() > 0)
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
                @foreach($usuarios as $usuario)
                <tr class="hover:bg-teal-200 cursor-pointer w-full">
                    <div>
                        <!-- <a href="#" > -->
                            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->rol }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($usuario->email_verified_at)
                                    Verificado
                                @else
                                    No verificado
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->updated_at }}</td>
                        <!-- </a> -->
                    </div>
                </tr>
                @endforeach
            </tbody>            
        </table>

    @else
        <p>No hay usuarios disponibles.</p>
    @endif

    <div class="footer-paginacion">
        <div class="botones-paginacion">

        </div>
    </div>
</div>

@endsection