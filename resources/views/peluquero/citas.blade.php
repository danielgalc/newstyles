@extends('layouts.peluquero_layout')

@section('title', 'Gestionar Citas')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Gestionar Citas') }}
</h2>
@endsection

@section('content')
<div class="container mx-auto mt-4">
    <!-- Contenido de la vista -->

    <h2 class="text-2xl font-semibold text-teal-600 mb-4">Bloquear Días y Horas</h2>
    <form action="{{ route('bloqueos.store') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="fecha_bloquear" class="block mb-2 text-sm font-medium text-gray-900">Fecha a Bloquear</label>
                <input id="fecha_bloquear" name="fecha" type="date" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-span-2">
                <label for="horas_bloquear" class="block mb-2 text-sm font-medium text-gray-900">Horas a Bloquear</label>
                <select id="horas_bloquear" name="horas[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                    @foreach (['10:00', '11:00', '12:00', '13:00', '16:00', '17:00', '18:00', '19:00', '20:00'] as $hora)
                    <option value="{{ $hora }}">{{ $hora }}</option>
                    @endforeach
                </select>
                <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
            </div>
        </div>
        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Bloquear</button>
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
