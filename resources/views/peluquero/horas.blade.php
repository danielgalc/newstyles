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
    <div class="container mx-auto flex flex-col justify-center items-center mt-4 w-1/3">
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

        <!-- Div del bloqueo de horas con efecto Glassmorfismo -->
        <div class="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-2 w-full max-w-md">
            <h2 class="text-3xl text-red-600 text-center mb-4 font-righteous">Bloquear Horas</h2>
            
            <form action="{{ route('bloqueos.store') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="fecha_bloquear" class="block mb-2 text-sm font-medium text-gray-200">Fecha a Bloquear</label>
                        <input id="fecha_bloquear" name="fecha" type="date" class="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-span-2">
                        <label for="horas_bloquear" class="block mb-2 text-sm font-medium text-gray-200">Horas a Bloquear</label>
                        <select id="horas_bloquear" name="horas[]" class="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                            <!-- Aquí se llenarán las horas disponibles mediante AJAX -->
                        </select>
                        <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
                    </div>
                </div>
                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Bloquear</button>
            </form>
        </div>

        <!-- Div del desbloqueo de horas con efecto Glassmorfismo -->
        <div class="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-2 w-full max-w-md mt-10">
            <h2 class="text-3xl text-teal-500 text-center mb-4 font-righteous">Desbloquear Horas</h2>
            
            <form action="{{ route('bloqueos.desbloquear') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="fecha_desbloquear" class="block mb-2 text-sm font-medium text-gray-200">Fecha a Desbloquear</label>
                        <input id="fecha_desbloquear" name="fecha" type="date" class="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-span-2">
                        <label for="horas_desbloquear" class="block mb-2 text-sm font-medium text-gray-200">Horas a Desbloquear</label>
                        <select id="horas_desbloquear" name="horas[]" class="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                            <!-- Aquí se llenarán las horas bloqueadas mediante AJAX -->
                        </select>
                        <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
                    </div>
                </div>
                <button type="submit" class="text-white bg-teal-500 hover:bg-teal-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Desbloquear</button>
            </form>
        </div>

        <div class="w-full mt-10 max-w-md py-2 px-4 text-red hover:before:bg-redborder-red-500 relative h-[50px] w-40 overflow-hidden bg-white px-3 text-red-500 shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-red-500 before:transition-all before:duration-500 hover:text-white hover:shadow-red-500 hover:before:left-0 hover:before:w-full">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link class="mt-auto text-xl relative z-10 text-red-500 hover:text-white" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Cerrar sesión') }}
                </x-dropdown-link>
            </form>
        </div>
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
</div>
@endsection
