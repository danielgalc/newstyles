<!-- resources/views/admin/lista_productos.blade.php -->
@extends('layouts.admin_layout')

@section('title', 'Lista de Servicios')

@section('content')

<div class="p-4">
    <div class="flex justify-between pb-4">
        <h2 class="text-4xl font-bold mb-4">Lista de Servicios</h2>
        <!-- Modal toggle -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 h-10 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Añadir nuevo servicio
        </button>
    </div>
    @if($productos->count() > 0)
        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creado en</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actualizado en</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($productos as $producto)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->descripcion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->precio }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->imagen }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $producto->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Mostrar enlaces de paginación -->
        {{ $productos->links() }}
    @else
        <p>No hay productos disponibles.</p>
    @endif
</div>
@endsection