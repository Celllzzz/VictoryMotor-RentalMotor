<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Victory Motor') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .text-victory { color: #F4E06D; }
            .bg-victory { background-color: #F4E06D; }
            .input-dark {
                background-color: #18181b; 
                border-color: #3f3f46;     
                color: white;
            }
            .input-dark:focus {
                border-color: #F4E06D;
                box-shadow: 0 0 0 1px #F4E06D;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-zinc-900">
        
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('images/background.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-br from-black via-black/80 to-black/60"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="mb-8 flex flex-col items-center">
                <a href="/" class="group flex flex-col items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-20 w-auto drop-shadow-2xl group-hover:scale-105 transition-transform duration-300" alt="Logo">
                    <div class="flex flex-col items-center leading-none mt-3">
                        <span class="text-white font-extrabold text-2xl tracking-widest uppercase">Victory</span>
                        <span class="text-victory font-bold text-xs tracking-[0.4em] uppercase">Motor</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-black/70 backdrop-blur-xl border border-white/10 shadow-2xl rounded-lg p-8">
                {{ $slot }}
            </div>

            <div class="mt-8 text-gray-400 text-xs tracking-wide">
                &copy; {{ date('Y') }} Victory Motor Semarang.
            </div>
        </div>
    </body>
</html>