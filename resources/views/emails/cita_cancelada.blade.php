<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita Cancelada</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(45 212 191);
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
            color: rgb(45 212 191); /* Primary color */
            text-align: center;
            font-family: 'Righteous', cursive; /* Aplicar la fuente Righteous */
        }
        p {
            color: #333333;
            line-height: 1.6;
        }
        .label {
            font-weight: bold;
            color: rgb(45 212 191); /* Primary color */
        }
        .message {
            background-color: #f9f9f9;
            padding: 10px;
            border-left: 4px solid rgb(45 212 191); /* Primary color */
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
        <h1>Cita Cancelada</h1>
        <p>Hola <span class="label">{{ $cita->user->name }}</span>,</p>
        <p>Lamentamos informarte que tu cita para el servicio de <span class="label">{{ $cita->servicio }}</span> con el peluquero <span class="label">{{ $cita->peluquero->name }}</span> el día <span class="label">{{ $cita->fecha }}</span> a las <span class="label">{{ $cita->hora }}</span> ha sido cancelada.</p>
        <p>Por favor, contacta con nosotros para más información.</p>
        <p>Gracias,</p>
        <p>Equipo de NewStyles</p>
    </div>
</body>
</html>
