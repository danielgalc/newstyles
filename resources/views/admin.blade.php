@extends('layouts.admin_layout')

@section('title', 'Dashboard')

@section('content')
    <div class="p-4">
        <!-- Aquí va el contenido específico de la página de administradores -->
        <h1 class="text-6xl font-bold mb-4">Bienvenido, {{ auth()->user()->name }}</h1>
        <!-- Agrega más contenido según sea necesario -->
    </div>
@endsection
