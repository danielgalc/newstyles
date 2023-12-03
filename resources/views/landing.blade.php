<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=YourCustomFont&display=swap">
    @vite('resources/css/app.css')

    <title>Document</title>
</head>
<body>
     <nav class="bg-gray-900 p-4 w-full flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('images/Logo1Transparente.png') }}" alt="Logo 1"  class="w-40 h-20">
        </div>

        <div class="bg-gray-900 p-8 w-full flex items-center justify-between">
            <div class="flex w-full justify-center items-center left-12 space-x-24"> <!-- Ajusta el valor de space-x según sea necesario -->
                <a href="#" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">Servicios</a>
                <a href="#" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">Productos</a>
                <a href="#" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">Quiénes Somos</a>        
            </div>
        </div>
        
            <!-- Verifica si el usuario está logueado -->
            {{-- @if ($usuarioLogueado)
                <!-- Si está logueado, muestra el icono de usuario y el desplegable -->
                <div class="relative group inline-block text-white">
                    <i class="fas fa-user mr-2"></i>
                    <ul class="absolute hidden bg-teal-400 text-white p-2 space-y-2">
                        <li><a href="#">Mi Perfil</a></li>
                        <li><a href="#">Historial de Citas</a></li>
                        <li><a href="#">Historial de Compra</a></li>
                    </ul>
                </div>
            @else --}}
            <!-- Si no está logueado, muestra enlaces de inicio de sesión -->
            <div class="flex items-center space-x-4 ml-auto border border-white"> <!-- Utiliza ml-auto para moverlo a la derecha -->
                <a href="#" class="text-white">Login</a>
                <a href="#" class="text-white">Registrarse</a>
            </div>
            {{-- @endif --}}
        </div>
        
        
            
    </nav>
    
<div class="flex items-center">
    <div class="h-96 w-full relative">
        <img src="https://bracknell.activatelearning.ac.uk/app/uploads/sites/2/2020/12/gen_Hairdressing_03-e1610560564268-1240x460.jpg" alt="Imagen" class="w-full h-full object-cover rounded-lg object-left-top">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white"></div>
    </div>

    <div class="w-2/4 p-8 flex flex-col items-center justify-center">
        <p class="text-gray-800 font-bold text-xl text-center mb-4">
            Descubre la experiencia de belleza en Newstyles, donde cada corte es una obra maestra. Nuestros estilistas expertos están aquí para realzar tu estilo único y dejarte sintiéndote renovado. 
            <br><br> ¡Bienvenid@ a un mundo de elegancia y estilo!
        </p>
        <button type="submit" class="bg-teal-500 hover:bg-teal-700 rounded-md px-8 py-4 shadow-md text-white font-bold text-lg transform transition-transform duration-300 ease-in-out hover:scale-105">¡Reserva tu cita ahora!</button>
    </div>
</div>


<div class="bg-white h-1/3 w-full flex items-center justify-center my-8">
    <div class="grid grid-cols-5 gap-24">
        <!-- Primer div -->
        <div class="group bg-teal-500 w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-white transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
            <img src="ruta/a/tu/logo1.png" alt="Logo 1" class="mb-2">
            <h2 class="text-2xl font-bold mb-2">+2K CLIENTES</h2>
            <p class="text-center">Cada vez son más los que confían en nosotros.</p>
        </div>
        <!-- Segundo div -->
        <div class="group bg-white w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-black transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
            <img src="ruta/a/tu/logo2.png" alt="Logo 2" class="mb-2">
            <h2 class="text-2xl font-bold mb-2">EXPERIENCIA</h2>
            <p class="text-center">Más de una década en funcionamiento.</p>
        </div>
        <!-- Tercer div -->
        <div class="group bg-teal-500 w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-white transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
            <img src="ruta/a/tu/logo3.png" alt="Logo 3" class="mb-2">
            <h2 class="text-2xl font-bold mb-2">SERVICIOS</h2>
            <p class="text-center">Disfruta de todos nuestros servicios a un precio económico.</p>
        </div>
        <!-- Cuarto div -->
        <div class="group bg-white w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-black transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
            <img src="ruta/a/tu/logo4.png" alt="Logo 4" class="mb-2">
            <h2 class="text-2xl font-bold mb-2">PRODUCTOS</h2>
            <p class="text-center">Elige entre una amplia gama de productos de alta calidad.</p>
        </div>
        <!-- Quinto div -->
        <div class="group bg-teal-500 w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-white transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
            <img src="ruta/a/tu/logo5.png" alt="Logo 5" class="mb-2">
            <h2 class="text-2xl font-bold mb-2">CRECIMIENTO</h2>
            <p class="text-center">Evolucionamos para crecer juntos, adaptándonos a las nuevas necesidades.</p>
        </div>
    </div>
</div>

<div class="bg-teal-400 h-1/3 p-4 min-h-full flex flex-col items-center justify-center">
    <h1 class="text-white text-4xl font-bold mb-8">¡Echa un vistazo a las reseñas de los usuarios!</h1>

    <div class="grid grid-rows-2 grid-cols-3 gap-16">
        <div class="bg-white w-96 h-44 p-3 rounded-md">
            <!-- Contenido -->
            <!-- ... -->
        </div>
        <div class="bg-white p-8 rounded-md">
            <!-- Contenido -->
            <!-- ... -->
        </div>
        <div class="bg-white p-8 rounded-md">
            <!-- Contenido -->
            <!-- ... -->
        </div>
        <div class="bg-white p-8 rounded-md">
            <!-- Contenido -->
            <!-- ... -->
        </div>
        <div class="bg-white w-96 h-44 p-8 rounded-md">
            <!-- Contenido -->
            <!-- ... -->
        </div>
        <div class="bg-white p-8 rounded-md">
            <!-- Contenido -->
            <!-- ... -->
        </div>
    </div>
</div>
<body>
</html>