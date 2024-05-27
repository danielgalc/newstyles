<x-app-layout>
    <div class="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
        <h2 class="font-righteous text-4xl text-gray-800 leading-tight">
            {{ __('Historial de Citas') }}
        </h2>
    </div>
    <div class="container mx-auto mt-4">

        @if($proximaCita)
            <div class="proxima-cita bg-white p-4 rounded-md shadow-md mb-6">
                <h2 class="text-xl font-semibold text-teal-600 mb-2">
                    @if($proximaCita->estado !== 'finalizada')
                        Tu próxima cita es:
                    @else
                        Tu última cita fue:
                    @endif
                </h2>
                <p><strong>Servicio:</strong> {{ $proximaCita->servicio }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($proximaCita->estado) }}</p>
            </div>
        @else
            <p class="mb-6">No tienes citas próximas.</p>
        @endif

        <h2 class="text-2xl font-semibold text-teal-600 mb-4">Citas Finalizadas</h2>
        @if($citasFinalizadas->isEmpty())
            <p>No tienes citas finalizadas.</p>
        @else
            @foreach($citasFinalizadas as $cita)
                <div class="cita-finalizada bg-white p-4 rounded-md shadow-md mb-4">
                    <p><strong>Servicio:</strong> {{ $cita->servicio }}</p>
                    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
                    <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</p>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
