@extends('layouts.admin_layout')

@section('title', 'Dashboard')

@section('content')
    <div id="content-container">
        <h1 class="text-6xl font-bold mb-4">Bienvenido, {{ auth()->user()->name }}</h1>
    </div>
@endsection
