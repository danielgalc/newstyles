<!DOCTYPE html>
<html>
<head>
    <title>Pedido PDF</title>
    <!-- Incluye cualquier otra cabecera que necesites -->
</head>
<body>
    <div id="detallesContenido">
        <h1>Detalles del Pedido</h1>
        <p><strong>Transacción:</strong> {{ $pedido->transaccion }}</p>
        <p><strong>Fecha de Compra:</strong> {{ $pedido->fecha_compra }}</p>
        <p><strong>Precio Total:</strong> {{ $pedido->precio_total }} €</p>
        <p><strong>DNI:</strong> {{ $pedido->dni }}</p>
        <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
        <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
        <h2 class="text-xl font-semibold text-teal-600 mb-2">Productos Comprados:</h2>
        <ul>
            @foreach($productos as $producto)
                <li>{{ $producto->nombre }} - Cantidad: {{ $producto->cantidad }}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
