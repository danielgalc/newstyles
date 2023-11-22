<form action="{{route('productos.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="Nombre"> Nombre del producto</label>
    <input type="text" name="nombre" id="descripcion">
    <br>
    
    <label for="Descripción"> Descripción </label>
    <input type="text" name="descripcion" id="descripcion">
    <br>

    <label for="Precio"> Precio</label>
    <input type="text" name="precio" id="precio">
    <br>

    <label for="Imagen"> Imagen</label>
    <input type="file" name="imagen" id="imagen">
    <br>

    <label for="Stock"> Stock</label>
    <input type="text" name="stock" id="stock">
    <br>
    
    <a href="/productos"><button type="submit">Añadir producto</button></a>
</form>