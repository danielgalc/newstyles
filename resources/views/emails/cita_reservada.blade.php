<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita Reservada</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(45, 212, 191);
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
            filter: drop-shadow(0.5px 1px 1px #000000);
        }
        h1 {
            color: rgb(45, 212, 191); /* Primary color */
            text-align: center;
            font-family: 'Righteous', cursive; /* Aplicar la fuente Righteous */
        }
        p {
            color: #333333;
            line-height: 1.6;
        }
        .label {
            font-weight: bold;
            color: rgb(45, 212, 191); /* Primary color */
        }
        .message {
            background-color: #f9f9f9;
            padding: 10px;
            border-left: 4px solid rgb(45, 212, 191); /* Primary color */
            margin-top: 10px;
            font-style: italic;
            font-weight: lighter;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container flex flex-col items-center justify-center">
        <div class="logo">
            <img src="{{ asset('images/Logo1Transparente.png') }}" alt="Logo">
        </div>
        <h1>Tu cita ha sido reservada</h1>
        <p>Hola <span class="label">{{ $cita->user->name }}</span>,</p>
        <p>Tu cita para el servicio de <span class="label">{{ $cita->servicio }}</span> ha sido reservada y está pendiente de confirmación.</p>
        <p>Detalles de la cita:</p>
        <ul>
            <li><span class="label">Fecha:</span> {{ $cita->fecha }}</li>
            <li><span class="label">Hora:</span> {{ $cita->hora }}</li>
            <li><span class="label">Peluquero:</span> {{ $cita->peluquero->name }}</li>
        </ul>
        <p>Por favor, revisa tu historial de citas para comprobar el estado de tu cita.</p>
        <p>Gracias por confiar en nosotros. ¡Esperamos verte pronto!</p>
        <p>Saludos,</p>
        <p>Equipo de NewStyles</p>
    </div>
</body>
</html>
