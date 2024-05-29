<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    <div class="flex h-screen">
        <!-- Barra de navegación izquierda -->
        <div class="flex flex-col w-64 bg-teal-400 shadow-md text-xl font-inter text-center pt-4">
            <!-- Logo del sitio -->
            <div class="text-black text-2xl font-semibold mb-4">
                <a href="/admin">
                    <img src="{{ asset('images/png/logo-black-transparente.png') }}" alt="Logo Black" class="w-40 h-auto m-auto z-index-1">
                </a>
            </div>

            <!-- Correo electrónico del administrador con línea inferior -->
            <div class="mb-4 py-2 border-b border-black font-inter text-sm font-thin italic px-4">
                {{ auth()->user()->email }}
            </div>

            <!-- Enlaces de navegación -->

            <nav class="nav-admin p-4">
                <ul class="space-y-8 mt-4 ">
                    <li class="transition-all duration-150 hover:scale-105">
                        <a href="{{ route('admin.usuarios') }}" class="text-white flex items-center font-inter text-[18px] hover:text-teal-700">
                            <svg class="svg-icon-2 mr-2 pb-1 hover:text-teal-700" xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" fill="currentColor">
                                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                            </svg>
                            Usuarios
                        </a>
                    </li>

                    <li class="transition-all duration-150 hover:scale-105">
                        <a href="{{ route('admin.citas') }}" class="text-white flex items-center font-inter text-[18px] hover:text-teal-700">
                            <svg fill="currentColor" class="mr-2.5 pb-1" height="32" width="28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 610.398 610.398" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path d="M159.567,0h-15.329c-1.956,0-3.811,0.411-5.608,0.995c-8.979,2.912-15.616,12.498-15.616,23.997v10.552v27.009v14.052 c0,2.611,0.435,5.078,1.066,7.44c2.702,10.146,10.653,17.552,20.158,17.552h15.329c11.724,0,21.224-11.188,21.224-24.992V62.553 V35.544V24.992C180.791,11.188,171.291,0,159.567,0z"></path>
                                            <path d="M461.288,0h-15.329c-11.724,0-21.224,11.188-21.224,24.992v10.552v27.009v14.052c0,13.804,9.5,24.992,21.224,24.992 h15.329c11.724,0,21.224-11.188,21.224-24.992V62.553V35.544V24.992C482.507,11.188,473.007,0,461.288,0z"></path>
                                            <path d="M539.586,62.553h-37.954v14.052c0,24.327-18.102,44.117-40.349,44.117h-15.329c-22.247,0-40.349-19.79-40.349-44.117 V62.553H199.916v14.052c0,24.327-18.102,44.117-40.349,44.117h-15.329c-22.248,0-40.349-19.79-40.349-44.117V62.553H70.818 c-21.066,0-38.15,16.017-38.15,35.764v476.318c0,19.784,17.083,35.764,38.15,35.764h468.763c21.085,0,38.149-15.984,38.149-35.764 V98.322C577.735,78.575,560.671,62.553,539.586,62.553z M527.757,557.9l-446.502-0.172V173.717h446.502V557.9z"></path>
                                            <path d="M353.017,266.258h117.428c10.193,0,18.437-10.179,18.437-22.759s-8.248-22.759-18.437-22.759H353.017 c-10.193,0-18.437,10.179-18.437,22.759C334.58,256.074,342.823,266.258,353.017,266.258z"></path>
                                            <path d="M353.017,348.467h117.428c10.193,0,18.437-10.179,18.437-22.759c0-12.579-8.248-22.758-18.437-22.758H353.017 c-10.193,0-18.437,10.179-18.437,22.758C334.58,338.288,342.823,348.467,353.017,348.467z"></path>
                                            <path d="M353.017,430.676h117.428c10.193,0,18.437-10.18,18.437-22.759s-8.248-22.759-18.437-22.759H353.017 c-10.193,0-18.437,10.18-18.437,22.759S342.823,430.676,353.017,430.676z"></path>
                                            <path d="M353.017,512.89h117.428c10.193,0,18.437-10.18,18.437-22.759c0-12.58-8.248-22.759-18.437-22.759H353.017 c-10.193,0-18.437,10.179-18.437,22.759C334.58,502.71,342.823,512.89,353.017,512.89z"></path>
                                            <path d="M145.032,266.258H262.46c10.193,0,18.436-10.179,18.436-22.759s-8.248-22.759-18.436-22.759H145.032 c-10.194,0-18.437,10.179-18.437,22.759C126.596,256.074,134.838,266.258,145.032,266.258z"></path>
                                            <path d="M145.032,348.467H262.46c10.193,0,18.436-10.179,18.436-22.759c0-12.579-8.248-22.758-18.436-22.758H145.032 c-10.194,0-18.437,10.179-18.437,22.758C126.596,338.288,134.838,348.467,145.032,348.467z"></path>
                                            <path d="M145.032,430.676H262.46c10.193,0,18.436-10.18,18.436-22.759s-8.248-22.759-18.436-22.759H145.032 c-10.194,0-18.437,10.18-18.437,22.759S134.838,430.676,145.032,430.676z"></path>
                                            <path d="M145.032,512.89H262.46c10.193,0,18.436-10.18,18.436-22.759c0-12.58-8.248-22.759-18.436-22.759H145.032 c-10.194,0-18.437,10.179-18.437,22.759C126.596,502.71,134.838,512.89,145.032,512.89z"></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            Gestionar citas
                        </a>
                    </li>
                    <li class="transition-all duration-150 hover:scale-105">
                        <a href="{{ route('admin.servicios') }}" class="text-white flex items-center font-inter text-[18px] hover:text-teal-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="30" fill="currentColor" class="tijeras-icon mr-2 pb-1" viewBox="0 0 16 16">
                                <path d="M3.5 3.5c-.614-.884-.074-1.962.858-2.5L8 7.226 11.642 1c.932.538 1.472 1.616.858 2.5L8.81 8.61l1.556 2.661a2.5 2.5 0 1 1-.794.637L8 9.73l-1.572 2.177a2.5 2.5 0 1 1-.794-.637L7.19 8.61 3.5 3.5zm2.5 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0zm7 0a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z" />
                            </svg>
                            Gestionar servicios
                        </a>
                    </li>
                    <li class="transition-all duration-150 hover:scale-105">
                        <a href="{{ route('admin.productos') }}" class="text-white flex items-center font-inter text-[18px] hover:text-teal-700">
                            <svg fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="34px" height="30px" class="mr-1.5 pb-1 productos-icon" stroke="currentColor">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path d="M431.123,299.707c0.476-1.695,0.892-3.448,1.223-5.272c3.633-20.059-3.262-41.132-20.495-62.638l-13.077-16.318 l-14.786,14.787c-15.842,15.842-25.134,13.346-49.975,6.666c-15.998-4.301-35.909-9.654-61.657-9.654 c-27.654,0-52.907,6.375-73.738,17.703l-5.068-106.016l-23.526-49.529V0H57.634v89.041L31.59,138.65L18.542,512h385.015 l24.976-174.829h27.461v31.22h37.463v-68.683H431.123z M95.097,37.463h37.463v37.463H95.097V37.463z M87.688,112.39h51.766 l11.862,24.976h-76.74L87.688,112.39z M56.764,474.537l0.5-24.976h92.591l3.568,24.976H56.764z M148.237,299.707h-19.791 l16.056,112.39H58.381l9.285-237.268h90.095l4.79,100.165C156.641,282.527,151.817,290.801,148.237,299.707z M371.064,474.537 H191.265l-19.625-137.366h215.671h3.378L371.064,474.537z M395.538,287.434c-0.91,5.553-4.166,9.74-6.732,12.273h-1.494H190.845 c15.928-21.581,45.85-34.966,81.51-34.966c20.8,0,37.339,4.447,51.931,8.371c21.77,5.853,44.132,11.867,68.268-2.228 C395.017,276.343,396.417,282.07,395.538,287.434z"></path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <rect x="231.212" y="387.122" width="99.902" height="37.463"></rect>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            Gestionar productos
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Cerrar Sesión al final -->
            <!-- Authentication -->
            <div class="w-full mt-auto py-2 px-4 text-red hover:before:bg-redborder-red-500 relative h-[50px] w-40 overflow-hidden bg-white px-3 text-red-500 shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-red-500 before:transition-all before:duration-500 hover:text-white hover:shadow-red-500 hover:before:left-0 hover:before:w-full">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link class="mt-auto text-xl relative z-10 text-red-500 hover:text-white" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
        <!-- Contenido principal -->
        <div class="flex-1 p-4 overflow-hidden overflow-y-auto">
            <!-- Aquí va el contenido específico de la página -->
            @yield('content')
        </div>
    </div>

    {{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Utilizando Axios para cargar dinámicamente el contenido de las secciones -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function loadSection(section, page = 1) {
        // Realiza una solicitud GET al servidor para obtener el contenido de la sección y la página actual
        axios.get(`/admin/${section}?page=${page}`)
            .then(response => {
                // Actualiza el contenido de la sección según la respuesta
                document.getElementById('content-container').innerHTML = response.data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
</script>

 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

</body>

</html>