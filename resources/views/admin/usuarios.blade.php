<!-- resources/views/admin/usuarios.blade.php -->
<div class="p-4">
    <h2 class="text-4xl font-bold mb-4">Lista de Usuarios</h2>
    @if($usuarios->count() > 0)
        <ul>
            @foreach($usuarios as $usuario)
                <li>{{ $usuario->name }} - {{ $usuario->email }}</li>
            @endforeach
        </ul>
    @else
        <p>No hay usuarios disponibles.</p>
    @endif
</div>
