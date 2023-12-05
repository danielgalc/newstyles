<nav class="bg-gray-900 p-4 w-full flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Logo1Transparente.png') }}" alt="Logo 1"  class="w-40 h-20">
        </a>
    </div>

    <div class="bg-gray-900 p-8 w-full flex items-center justify-between">
        <div class="flex w-full justify-center items-center space-x-24">
            <x-nav-link :href="('productos')" :active="request()->routeIs('productos')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                {{ __('Productos') }}
            </x-nav-link>
            <x-nav-link :href="('servicios')" :active="request()->routeIs('servicios')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                {{ __('Servicios') }}
            </x-nav-link>
            <x-nav-link :href="''" :active="request()->routeIs('')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                {{ __('Quiénes Somos') }}
            </x-nav-link>
            @if(Auth::user()->rol=='cliente')           
                <x-nav-link :href="('carrito')" :active="request()->routeIs('carrito')" class="text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                    {{ __('Ver carrito')}} ({{(Auth::user()->carrito()->sum('cantidad'))}})
                </x-nav-link>
            @endif
        </div>
    </div>



    <div class="hidden sm:flex sm:items-center sm:ms-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>
    
            <x-slot name="content">
                <x-dropdown-link :href="('perfil')" :active="request()->routeIs('perfil')">
                    {{ __('Mi perfil') }}
                </x-dropdown-link>
    
                <x-dropdown-link :href="('historial-citas')" :active="request()->routeIs('historial-citas')">
                    {{ __('Historial de citas') }}
                </x-dropdown-link>
    
                <x-dropdown-link :href="('historial-pedidos')" :active="request()->routeIs('historial-pedidos')">
                    {{ __('Historial de pedidos') }}
                </x-dropdown-link>
    
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Configuración') }}
                </x-dropdown-link>
    
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link style="color: red" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
    
</nav>
