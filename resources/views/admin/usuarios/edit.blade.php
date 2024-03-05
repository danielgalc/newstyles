<form action="{{ route('usuarios.update', ['id' => $user->id]) }}" method="POST">

    @csrf
    @method('PUT')

    <label for="Nombre">Nombre del usuario</label>
    <input type="text" name="name" id="name" value="{{ $user->name }}">
    <br>
    
    <label for="Email">Correo electrónico</label>
    <input type="email" name="email" id="email" value="{{ $user->email }}">
    <br>

    <label for="Password">Contraseña</label>
    <input type="password" name="password" id="password">
    <br>

    <label for="Rol">Rol</label>
    <select name="rol" id="rol">
        <option value="cliente" {{ $user->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
        <option value="admin" {{ $user->rol == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    <br>
    
    <button type="submit">Modificar usuario</button>
</form>
