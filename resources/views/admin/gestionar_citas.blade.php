<!-- resources/views/admin/usuarios.blade.php -->
<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Citas</h2>
    @if($citas->count() > 0)
        <ul>
            @foreach($citas as $cita)
                <li>{{ $cita->id }} - {{ $cita->user->name }} - {{ $cita->peluquero->name }} - {{ $cita->servicio }} - {{ $cita->fecha }} - {{ $cita->hora }} - {{ $cita->estado }}</li>
            @endforeach
        </ul>
    @else
        <p>No hay citas disponibles.</p>
    @endif
</div>
