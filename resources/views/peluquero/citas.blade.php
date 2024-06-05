@extends('layouts.peluquero_layout')

@section('title', 'Gestionar Citas')

@section('header')
<div class="flex justify-center gap-16 text-3xl font-righteous text-white">
    <a href="/peluquero/horas" class="hover:text-teal-500 transition-all duration-300 transform hover:scale-105">Gestionar Horas</a>
    <a href="/peluquero/citas" class="hover:text-teal-500 transition-all duration-300 transform hover:scale-105">Gestionar Citas</a>
</div>
@endsection

@section('content')
<div class="relative min-h-screen bg-gray-800 pt-20">
    <div class="container mx-auto flex gap-8 justify-center items-start mt-4">
        <!-- Mensajes de éxito -->
        @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4 w-full">
            {{ session('success') }}
        </div>
        @endif

        <!-- Mensajes de error -->
        @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-md mb-4 w-full">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Div para seleccionar la fecha y mostrar citas del día -->
        <div class="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg p-8 w-full max-w-md">
            <h2 class="text-3xl text-teal-500 text-center mb-4 font-righteous">Citas del Día</h2>
            <div class="grid gap-4 mb-4 grid-cols-1">
                <label for="fecha_citas" class="block mb-2 text-sm font-medium text-gray-200">Seleccionar Fecha</label>
                <input id="fecha_citas" type="date" class="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
            <div id="citas_del_dia" class="grid gap-4">
            </div>
            <p id="no_citas_del_dia" class="text-gray-200 text-center">No hay citas para la fecha seleccionada.</p>
        </div>

        <!-- Div para mostrar citas pendientes -->
        <div class="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg p-8 w-full max-w-md">
            <h2 class="text-3xl text-red-600 text-center mb-4 font-righteous">Citas Pendientes</h2>
            <div id="citas_pendientes" class="grid gap-4">
                @if($citasPendientes->isEmpty())
                <p class="text-gray-200 text-center">No hay citas pendientes.</p>
                @else
                @foreach($citasPendientes as $cita)
                <div class="bg-white p-4 rounded-lg shadow-md text-gray-800 transition duration-300 transform hover:scale-105 hover:bg-teal-200">
                    <p><strong>Cliente:</strong> {{ $cita->user->name }}</p>
                    <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
                    <p><strong>Hora:</strong> {{ $cita->hora }}</p>
                    <p><strong>Servicio:</strong> {{ $cita->servicio }}</p>
                    <div class="flex justify-end mt-4">
                        <form action="{{ route('citas.aceptar', $cita->id) }}" method="post" class="mr-2">
                            @csrf
                            <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded">Aceptar</button>
                        </form>
                        <form action="{{ route('citas.cancelar', $cita->id) }}" method="post">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cancelar</button>
                        </form>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaCitasInput = document.getElementById('fecha_citas');
        const citasDelDiaContainer = document.getElementById('citas_del_dia');
        const noCitasDelDiaText = document.getElementById('no_citas_del_dia');

        const today = new Date().toISOString().split('T')[0];
        fechaCitasInput.value = today;

        function loadCitasDelDia(fecha) {
            fetch(`/citas/obtenerCitasDelDia?fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    citasDelDiaContainer.innerHTML = '';
                    console.log('Citas del día: ', data.length, data.length === 0)
                    if (data.length === 0) {
                        noCitasDelDiaText.style.display = 'block';
                    } else {
                        console.log('Citas del día, else: ', data.length)
                        noCitasDelDiaText.style.display = 'none';
                        const currentTime = new Date().toTimeString().split(' ')[0];
                        data.forEach(cita => {
                            const citaCard = document.createElement('div');
                            const isPast = fecha === today && cita.hora < currentTime;
                            citaCard.classList.add('p-4', 'rounded-lg', 'shadow-md', 'text-gray-800', 'mb-4', 'transition', 'duration-300', 'transform', isPast ? 'bg-gray-300' : 'bg-white', !isPast && 'hover:scale-105', !isPast && 'hover:bg-teal-200');
                            citaCard.innerHTML = `
                                <p><strong>Cliente:</strong> ${cita.user.name}</p>
                                <p><strong>Fecha:</strong> ${cita.fecha}</p>
                                <p><strong>Hora:</strong> ${cita.hora}</p>
                                <p><strong>Servicio:</strong> ${cita.servicio}</p>
                            `;
                            citasDelDiaContainer.appendChild(citaCard);
                        });
                    }
                });
        }

        loadCitasDelDia(today);

        fechaCitasInput.addEventListener('input', function() {
            const fecha = this.value;
            loadCitasDelDia(fecha);
        });
    });
</script>
@endsection