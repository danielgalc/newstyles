@extends('layouts.peluquero_layout')

@section('title', 'Gestionar Citas')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Gestionar Citas') }}
</h2>
@endsection

@section('content')
<div class="container mx-auto mt-4">
    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensajes de error -->
    @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-md mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                    @foreach (['10:00:00', '11:00:00', '12:00:00', '13:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'] as $hora)
                        <option value="{{ $hora }}">{{ substr($hora, 0, 5) }}</option>
                    @endforeach
                </select>
                <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
            </div>
        </div>
        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Bloquear</button>
    </form>

    <h2 class="text-2xl font-semibold text-teal-600 mb-4">Desbloquear Días y Horas</h2>
    <form action="{{ route('bloqueos.desbloquear') }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="fecha_desbloquear" class="block mb-2 text-sm font-medium text-gray-900">Fecha a Desbloquear</label>
                <input id="fecha_desbloquear" name="fecha" type="date" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-span-2">
                <label for="horas_desbloquear" class="block mb-2 text-sm font-medium text-gray-900">Horas a Desbloquear</label>
                <select id="horas_desbloquear" name="horas[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                    <!-- Aquí se llenarán las horas bloqueadas mediante AJAX -->
                </select>
                <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
            </div>
        </div>
        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Desbloquear</button>
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
        const horasBloquearSelect = document.getElementById('horas_bloquear');
        const fechaDesbloquearInput = document.getElementById('fecha_desbloquear');
        const horasDesbloquearSelect = document.getElementById('horas_desbloquear');
        const userId = {{ Auth::id() }};

        const todasLasHoras = ['10:00:00', '11:00:00', '12:00:00', '13:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'];

        function loadHorasDisponibles(fecha, selectElement, bloquear = true) {
            fetch(`{{ route('bloqueos.horas-bloqueadas') }}?user_id=${userId}&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    selectElement.innerHTML = '';
                    if (bloquear) {
                        const horasDisponibles = todasLasHoras.filter(hora => !data.includes(hora));
                        horasDisponibles.forEach(hora => {
                            const option = document.createElement('option');
                            option.value = hora;
                            option.textContent = hora.slice(0, 5);
                            selectElement.appendChild(option);
                        });
                    } else {
                        data.forEach(hora => {
                            const option = document.createElement('option');
                            option.value = hora;
                            option.textContent = hora.slice(0, 5);
                            selectElement.appendChild(option);
                        });
                    }
                });
        }

        fechaBloquearInput.addEventListener('input', function() {
            hideError(this);
            const selectedDate = this.value;
            const day = new Date(selectedDate).getUTCDay();

            if (day === 6 || day === 0) {
                showError(this, 'No se pueden seleccionar fines de semana. Por favor, elige otro día.');
                this.value = '';
            } else {
                loadHorasDisponibles(selectedDate, horasBloquearSelect);
            }
        });

        fechaDesbloquearInput.addEventListener('input', function() {
            hideError(this);
            const selectedDate = this.value;
            loadHorasDisponibles(selectedDate, horasDesbloquearSelect, false);
        });

        const today = new Date().toISOString().split('T')[0];
        fechaBloquearInput.setAttribute('min', today);
        fechaDesbloquearInput.setAttribute('min', today);
    });
</script>
@endsection
