<!DOCTYPE html>
<html>
<head>
    <title>Pedido PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        .header, .footer {
            text-align: center;
            padding: 10px 0;
        }
        .header {
            background-color: rgb(20, 184, 166); /* Teal-400 */
            color: #fff;
        }
        .footer {
            background: #333;
            color: #fff;
        }
        .content {
            margin: 20px 0;
        }
        .content h1 {
            color: rgb(20, 184, 166); /* Teal-400 */
        }
        .content p {
            margin: 10px 0;
        }
        .products {
            margin: 20px 0;
        }
        .products table {
            width: 100%;
            border-collapse: collapse;
        }
        .products table, .products th, .products td {
            border: 1px solid #ddd;
        }
        .products th, .products td {
            padding: 10px;
            text-align: left;
        }
        .products th {
            background-color: rgb(20, 184, 166); /* Teal-400 */
            color: #fff;
        }
        .products img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalles del Pedido</h1>
        </div>
        <div class="content">
            <p><strong>Transacción:</strong> {{ $pedido->transaccion }}</p>
            <p><strong>Fecha de Compra:</strong> {{ $pedido->fecha_compra }}</p>
            <p><strong>Precio Total:</strong> {{ $pedido->precio_total }} €</p>
            <p><strong>DNI:</strong> {{ $pedido->dni }}</p>
            <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
            <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
        </div>
        <div class="products">
            <h2>Productos Comprados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <h2>Gracias por su compra</h2>
            <p>El equipo de NewStyles</p>
        </div>
    </div>
</body>
</html>
