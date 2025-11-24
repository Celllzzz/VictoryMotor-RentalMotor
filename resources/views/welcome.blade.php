<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Victory Motor - Rental Motor Semarang</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,600,700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* --- BRAND COLORS --- */
        .text-victory { color: #F4E06D; }
        .bg-victory { background-color: #F4E06D; }
        .border-victory { border-color: #F4E06D; }

        /* --- CUSTOM UTILITIES --- */
        .glass-nav {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Animasi Garis Bawah Navigasi */
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #F4E06D;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Animasi Tombol Pulse Halus */
        @keyframes subtlePulse {
            0% { box-shadow: 0 0 0 0 rgba(244, 224, 109, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(244, 224, 109, 0); }
            100% { box-shadow: 0 0 0 0 rgba(244, 224, 109, 0); }
        }
        .btn-pulse:hover {
            animation: subtlePulse 2s infinite;
        }

        /* Text Shadow untuk Readability */
        .text-glow {
            text-shadow: 0 0 20px rgba(0,0,0,0.8);
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden bg-zinc-900 text-white antialiased font-sans selection:bg-yellow-500 selection:text-black">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/background.jpg') }}" alt="Victory Background" class="w-full h-full object-cover opacity-70 transform scale-105">
        
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/40"></div>
    </div>

    <div class="relative z-10 h-full flex flex-col justify-between px-6 md:px-16 py-6">

        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div class="flex items-center gap-4 group cursor-default">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto drop-shadow-md group-hover:scale-110 transition-transform duration-300">
                <div class="flex flex-col leading-tight">
                    <span class="text-white font-extrabold text-lg tracking-wider uppercase">Victory</span>
                    <span class="text-victory font-medium text-xs tracking-[0.2em] uppercase group-hover:tracking-[0.3em] transition-all duration-300">Motor</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-8 text-xs font-bold tracking-widest uppercase">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link text-white hover:text-victory transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link text-white hover:text-victory transition-colors">Log In</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 border border-white/20 hover:border-victory text-victory rounded-sm transition-all duration-300 hover:bg-victory hover:text-black">
                        Create Account
                    </a>
                @endauth
            </div>
        </nav>

        <main class="flex flex-col justify-center items-start w-full max-w-3xl space-y-6 md:pl-4">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 border border-victory/30 bg-victory/10 rounded-full animate-fade-in-down">
                <span class="w-2 h-2 rounded-full bg-victory animate-ping"></span>
                <span class="text-victory text-[10px] font-bold tracking-widest uppercase">Premium Rental Service</span>
            </div>

            <div class="space-y-0">
                <h1 class="text-5xl md:text-7xl font-bold text-white tracking-tight leading-none text-glow">
                    RENTAL MADE
                </h1>
                <h1 class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-600 tracking-tight leading-none drop-shadow-lg">
                    SIMPLE & FAST
                </h1>
            </div>

            <p class="text-gray-300 text-sm md:text-lg font-light max-w-md leading-relaxed border-l-2 border-victory pl-4 mt-4">
                Solusi transportasi terbaik di Semarang. Armada terawat, harga transparan, dan pelayanan 24 jam.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 mt-8 w-full max-w-sm">
                <a href="{{ route('booking.step1') }}" 
                   class="group flex-1 bg-victory text-black font-bold text-center py-4 px-6 rounded-sm uppercase tracking-wider btn-pulse hover:bg-white transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-yellow-500/20">
                    <span>Book Now</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                
                @guest
                <a href="{{ route('register') }}" 
                   class="flex-1 border border-white/30 text-white font-bold text-center py-4 px-6 rounded-sm uppercase tracking-wider hover:bg-white/10 hover:border-white transition-all duration-300">
                    Join Us
                </a>
                @endguest
            </div>

        </main>

        <footer class="border-t border-white/10 pt-6 mt-8">
            <div class="grid grid-cols-3 gap-4 md:gap-12 max-w-2xl">
                <div class="flex flex-col">
                    <span class="text-victory font-black text-xl md:text-2xl">50+</span>
                    <span class="text-gray-400 text-[10px] md:text-xs uppercase tracking-wider">Ready Bikes</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-4 md:pl-12">
                    <span class="text-victory font-black text-xl md:text-2xl">24/7</span>
                    <span class="text-gray-400 text-[10px] md:text-xs uppercase tracking-wider">Support</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-4 md:pl-12">
                    <span class="text-victory font-black text-xl md:text-2xl">100%</span>
                    <span class="text-gray-400 text-[10px] md:text-xs uppercase tracking-wider">Secure Payment</span>
                </div>
            </div>
            
            <div class="mt-4 text-[10px] text-gray-600">
                &copy; {{ date('Y') }} Victory Motor Semarang. All rights reserved.
            </div>
        </footer>

    </div>
</body>
</html>