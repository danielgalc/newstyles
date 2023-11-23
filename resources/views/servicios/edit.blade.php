<form action="{{ route('servicios.update', ['id' => $servicio->id]) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <label for="Nombre">Nombre del servicio</label>
    <input type="text" name="nombre" id="nombre" value="{{ $servicio->nombre }}">
    <br>

    <label for="Precio">Precio</label>
    <input type="text" name="precio" id="precio" value="{{ $servicio->precio }}">
    <br>

    <label for="Duración">Duración</label>
    <input type="text" name="duracion" id="duracion" value="{{ $servicio->duracion }}">
    <br>
    
    <a href="/servicios"><button type="submit">Modificar servicio</button></a>
</form>