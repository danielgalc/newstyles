<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold leading-tight">
            {{ __('PERFIL') }}
        </h2>
    </x-slot>
        <div style="display: flex">
                <p class="text-4xl">{{ $users->name }}</p>
                <p class="text-2xl pt-8">{{ $users->email }}</p>
        </div>
</x-app-layout>