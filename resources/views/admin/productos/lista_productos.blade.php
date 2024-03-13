<!-- resources/views/admin/lista_productos.blade.php -->
@extends('layouts.admin_layout')

@section('title', 'Lista de Servicios')

@section('content')

<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Productos</h2>
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
    @else
        <p>No hay productos disponibles.</p>
    @endif
</div>
@endsection