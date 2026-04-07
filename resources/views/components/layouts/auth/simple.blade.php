<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased custome-background"  
            style="background-image: url('{{ asset('assets/img/BackgroundTifa1.png') }}');
           background-size: cover;
           background-position: center;
           background-repeat: no-repeat;">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center md:p-4">
            <div class="">
                {{-- <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate> --}}
                    {{-- <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md"> --}}
                        {{-- <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" /> --}}
                    {{-- </span> --}}
                    {{-- <span class="sr-only">{{ config('app.name', 'Laravel') }}</span> --}}
                {{-- </a> --}}
                <div class="flex flex-col">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @livewireScripts
        @fluxScripts
    </body>
</html>
