<h1>Añadir un nuevo servicio</h1>

<form action="{{route('servicios.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="Nombre"> Nombre del servicio</label>
    <input type="text" name="nombre" id="nombre">
    <br>
    
    <label for="Precio"> Precio </label>
    <input type="text" name="precio" id="precio">
    <br>

    <label for="Duración"> Duración</label>
    <input type="text" name="duracion" id="duracion">
    <br>
    
    <a href="/servicios"><button type="submit">Añadir servicio</button></a>
</form>