<div className="min-h-screen">
    <nav class="bg-gray-900 p-5 w-full flex items-center justify-between">
        <div className="flex items-center">

            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/Logo1Transparente.png') }}" alt="Logo 1" class="w-40 h-20">
            </a>
        </div>

        <div class="bg-gray-900 p-4 w-full flex items-center justify-between font-righteous">
            <div class="flex w-full justify-center mb-1 space-x-24">
                <x-nav-link :href="('productos')" :active="request()->routeIs('productos')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                    {{ __('Productos') }}
                </x-nav-link>
                <x-nav-link :href="('servicios')" :active="request()->routeIs('servicios')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                    {{ __('Servicios') }}
                </x-nav-link>
                <x-nav-link :href="('quienes-somos')" :active="request()->routeIs('quienes-somos')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                    {{ __('Quiénes Somos') }}
                </x-nav-link>
            </div>
        </div>

        <div class="hidden sm:flex justify-center">
            @guest
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="text-white text-xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                {{ __('Iniciar sesión') }}
            </x-nav-link>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-white text-xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                {{ __('Registrarse') }}
            </x-nav-link>
            @else
            @if(Auth::user()->rol=='cliente')
            <x-nav-link :href="route('carrito')" :active="request()->routeIs('carrito')" class="mb-1 transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                <svg class="carrito-icono" xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 50 50" fill="none">
                    <path d="M0 2.08334H9.925L11.0604 6.25001H48.7229L41.0854 29.1667H16.2083L15.1667 33.3333H45.8333V37.5H9.83333L12.4292 27.1063L6.74167 6.25001H0V2.08334ZM16.175 25H38.0812L42.9437 10.4167H12.1979L16.175 25ZM8.33333 43.75C8.33333 42.6449 8.77232 41.5851 9.55372 40.8037C10.3351 40.0223 11.3949 39.5833 12.5 39.5833C13.6051 39.5833 14.6649 40.0223 15.4463 40.8037C16.2277 41.5851 16.6667 42.6449 16.6667 43.75C16.6667 44.8551 16.2277 45.9149 15.4463 46.6963C14.6649 47.4777 13.6051 47.9167 12.5 47.9167C11.3949 47.9167 10.3351 47.4777 9.55372 46.6963C8.77232 45.9149 8.33333 44.8551 8.33333 43.75ZM37.5 43.75C37.5 42.6449 37.939 41.5851 38.7204 40.8037C39.5018 40.0223 40.5616 39.5833 41.6667 39.5833C42.7717 39.5833 43.8315 40.0223 44.6129 40.8037C45.3943 41.5851 45.8333 42.6449 45.8333 43.75C45.8333 44.8551 45.3943 45.9149 44.6129 46.6963C43.8315 47.4777 42.7717 47.9167 41.6667 47.9167C40.5616 47.9167 39.5018 47.4777 38.7204 46.6963C37.939 45.9149 37.5 44.8551 37.5 43.75Z" fill="white" />
                </svg>
            </x-nav-link>
            @endif
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="inline-flex items-center text-center px-3 py-4 mt-1 border border-transparent leading-4 font-medium text-2xl rounded-md text-teal-300 hover:text-teal-200 focus:outline-none transition ease-in-out duration-150" type="button">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
                <div class="ms-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </div>

        <!-- Dropdown menu -->
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 text-gray-700">
            <ul class=" text-sm text-gray-900" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="profile" class="block px-4 py-2 hover:rounded-t-lg hover:bg-gray-100 dark:hover:bg-gray-200 ">Mi perfil</a>
                </li>
                <li>
                    <a href="historial-citas" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-200">Historial de citas</a>
                </li>
                <li>
                    <a href="historial_pedidos" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-200">Historial de pedidos</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="block px-4 py-2 cursor-pointer hover:bg-red-500 hover:rounded-b-lg" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </a>
                    </form>
                </li>
            </ul>


            @endguest
        </div>
    </nav>
</div>