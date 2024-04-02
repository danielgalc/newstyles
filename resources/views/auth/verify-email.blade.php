<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte por correo electrónico? Si no recibiste el correo electrónico, estaremos encantados de enviarte otro.') }}
    </div>
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-center">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
                <x-primary-button class="w-full flex justify-center items-center text-4xl">
                    {{ __('Reenviar correo de verificación') }}
                </x-primary-button>
        </form>

        {{-- <form method="POST" action="{{ route('logout') }}">
            @csrf
        
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
            <a href="{{ route('logout') }}" style="display:none;" onclick="event.preventDefault(); this.previousElementSibling.submit();">Logout</a>
        </form> --}}        
    </div>

    <div class="mt-4 flex items-center justify-center">
        <a href="{{ route('landing') }}" class="text-sm text-gray-600 underline hover:text-red-500">
            {{ __('No quiero confirmar mi correo electrónico ahora') }}
        </a>
    </div>
</x-guest-layout>
