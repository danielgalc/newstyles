<form action="{{ route('productos.update', ['id' => $producto->id]) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <label for="Nombre"> Nombre del producto</label>
    <input type="text" name="nombre" id="nombre" value="{{ $producto->nombre }}">
    
    <br>
    
    <label for="Descripción"> Descripción </label>
    <input type="text" name="descripcion" id="descripcion" value="{{ $producto->descripcion }}">
    <br>

    <label for="Precio"> Precio</label>
    <input type="text" name="precio" id="precio" value="{{ $producto->precio }}">
    <br>

    <label for="Imagen"> Imagen</label>
    <input type="file" name="imagen" id="imagen" value="{{ $producto->imagen }}">
    <br>

    <label for="Stock"> Stock</label>
    <input type="text" name="stock" id="stock" value="{{ $producto->stock }}">
    <br>
    
    <a href="/productos"><button type="submit">Modificar producto</button></a>
</form>