@extends('layouts.peluquero_layout')

@section('title', 'Gestionar Citas')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Gestionar Citas') }}
</h2>
@endsection

@section('content')
<div class="container mx-auto mt-4">
    <h2 class="text-2xl font-semibold text-teal-600 mb-4">Citas Pendientes</h2>
    @if($citasPendientes->isEmpty())
    <p>No tienes citas pendientes.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($citasPendientes as $cita)
        <div class="cita-pendiente bg-white p-4 rounded-md shadow-md mb-4 hover:bg-teal-100" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">
            <p><strong>Servicio:</strong> {{ $cita->servicio }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</p>
            <p><strong>Cliente:</strong> {{ $cita->user->name }}</p>
            <form action="{{ route('citas.aceptar', ['id' => $cita->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Aceptar</button>
            </form>
            <form action="{{ route('citas.cancelar', ['id' => $cita->id]) }}" method="post" class="mt-2">
                @csrf
                @method('PUT')
                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancelar</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

    <h2 class="text-2xl font-semibold text-teal-600 mb-4">Citas Aceptadas</h2>
    @if($citasAceptadas->isEmpty())
    <p>No tienes citas aceptadas.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($citasAceptadas as $cita)
        <div class="cita-aceptada bg-white p-4 rounded-md shadow-md mb-4 hover:bg-teal-100" data-modal-toggle="edit_cita_modal_{{ $cita->id }}" data-modal-target="edit_cita_modal_{{ $cita->id }}">
            <p><strong>Servicio:</strong> {{ $cita->servicio }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</p>
            <p><strong>Cliente:</strong> {{ $cita->user->name }}</p>
            <form action="{{ route('citas.cancelar', ['id' => $cita->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancelar</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

    <h2 class="text-2xl font-semibold text-teal-600 mb-4">Bloquear Días</h2>
    <form action="{{ route('citas.bloquear') }}" method="post">
        @csrf
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="fecha_bloquear" class="block mb-2 text-sm font-medium text-gray-900">Fecha a Bloquear</label>
                <input id="fecha_bloquear" name="fecha_bloquear" type="date" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
        </div>
        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Bloquear Fecha</button>
    </form>
</div>

<script>
    function showError(input, message) {
        // Eliminar mensaje de error anterior si existe
        const previousError = input.parentNode.querySelector('.help-block');
        if (previousError) {
            previousError.parentNode.removeChild(previousError);
        }

        const errorSpan = document.createElement('span');
        errorSpan.classList.add('help-block', 'text-red-500', 'text-sm');
        errorSpan.innerText = message;

        input.parentNode.appendChild(errorSpan);

        input.classList.add('border', 'border-red-500');
    }

    function hideError(input) {
        const errorSpan = input.parentNode.querySelector('.help-block');

        if (errorSpan) {
            errorSpan.parentNode.removeChild(errorSpan);
        }

        input.classList.remove('border', 'border-red-500');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const fechaBloquearInput = document.getElementById('fecha_bloquear');

        fechaBloquearInput.addEventListener('input', function() {
            hideError(this); // Ocultar error anterior

            const selectedDate = new Date(this.value);
            const day = selectedDate.getUTCDay();

            // Verificar si es fin de semana (sábado: 6, domingo: 0)
            if (day === 6 || day === 0) {
                showError(this, 'No se pueden seleccionar fines de semana. Por favor, elige otro día.');
                this.value = ''; // Limpiar valor del input
            }
        });

        // Deshabilitar días anteriores a la fecha actual
        const today = new Date().toISOString().split('T')[0];
        fechaBloquearInput.setAttribute('min', today);
    });
</script>
@endsection
