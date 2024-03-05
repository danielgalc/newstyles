<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf

    <label for="Nombre">Nombre del usuario</label>
    <input type="text" name="name" id="name">
    <br>
    
    <label for="Email">Correo electrónico</label>
    <input type="email" name="email" id="email">
    <br>

    <label for="Password">Contraseña</label>
    <input type="password" name="password" id="password">
    <br>

    <label for="Rol">Rol</label>
    <select name="rol" id="rol">
        <option value="cliente" selected>Cliente</option>
        <option value="cliente" selected>Admin</option>
    </select>
    <br>
    
    <button type="submit">Añadir usuario</button>
</form>
