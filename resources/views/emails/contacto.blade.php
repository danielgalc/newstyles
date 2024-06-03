{{-- resources/views/emails/contacto.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Message</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');

        body {
            font-family: Arial, sans-serif;
            background-color: #99a7ad;
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
        <h1>Nuevo Mensaje de Contacto</h1>
        <p><span class="label">Nombre:</span> {{ $name }}</p>
        <p><span class="label">Correo electrónico:</span> {{ $email }}</p>
        <p><span class="label">Asunto:</span> {{ $subject }}</p>
        <div class="message">
            <p><span class="label">Mensaje:</span></p>
            <p>{!! nl2br(e($content)) !!}</p>
        </div>
    </div>
</body>
</html>
