<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Victory Motor') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .text-victory { color: #F4E06D; }
        .bg-victory { background-color: #F4E06D; }
        .border-victory { border-color: #F4E06D; }
        
        /* Glass Navbar (Hitam Pekat) */
        .glass-nav {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        ::selection { background: #F4E06D; color: black; }
    </style>
</head>
<body class="bg-black text-white antialiased font-sans min-h-screen flex flex-col">

    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex justify-between items-center h-20">
                
                <a href="/" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="flex flex-col leading-none">
                        <span class="text-white font-black tracking-widest text-lg uppercase group-hover:text-gray-300 transition-colors">Victory</span>
                        <span class="text-victory font-bold tracking-[0.3em] text-[10px] uppercase">Motor</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    @auth
                        <a href="{{ route('booking.history') }}" class="text-xs font-bold uppercase tracking-[0.15em] text-zinc-400 hover:text-victory transition-colors relative group">
                            History
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-victory transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <a href="{{ route('booking.step1') }}" class="px-6 py-2.5 bg-victory text-black font-black uppercase tracking-widest text-[10px] rounded-sm hover:bg-white hover:scale-105 transition-all shadow-[0_0_15px_rgba(244,224,109,0.3)]">
                            Order Now
                        </a>

                        <div class="h-6 w-px bg-zinc-700"></div>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                                <div class="text-right hidden lg:block">
                                    <div class="text-xs font-bold text-white group-hover:text-victory transition-colors uppercase tracking-wider">{{ Auth::user()->nama }}</div>
                                </div>
                                
                                <div class="w-10 h-10 rounded-full bg-zinc-800 border-2 border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:border-victory group-hover:text-victory transition-all duration-300 overflow-hidden">
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('storage/'.Auth::user()->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    @endif
                                </div>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 transform translate-y-2 scale-95"
                                 class="absolute right-0 mt-4 w-56 bg-zinc-900 border border-zinc-700 rounded-sm shadow-2xl py-2 z-50 overflow-hidden"
                                 style="display: none;">
                                
                                <div class="px-5 py-3 border-b border-zinc-800">
                                    <p class="text-[10px] text-zinc-500 uppercase tracking-wider font-bold">Signed in as</p>
                                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-zinc-400 hover:bg-zinc-800 hover:text-victory transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    My Profile
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm text-red-500 hover:bg-zinc-800 hover:text-red-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="relative group text-xs font-bold uppercase tracking-[0.15em] text-zinc-400 transition-colors duration-300 hover:text-white">
                            Log In
                            <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-victory transition-all duration-300 group-hover:w-full"></span>
                        </a>

                        <a href="{{ route('register') }}" class="relative px-5 py-2 border border-zinc-700 text-white text-[10px] font-black uppercase tracking-widest rounded-sm transition-all duration-300 transform hover:-translate-y-1 hover:bg-white hover:text-black hover:border-white hover:shadow-[0_5px_15px_rgba(255,255,255,0.3)]">
                            Create Account
                        </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center" x-data="{ mobileOpen: false }">
                    <button @click="mobileOpen = !mobileOpen" class="text-white hover:text-victory transition-colors p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <div x-show="mobileOpen" @click.away="mobileOpen = false" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="absolute top-20 left-0 w-full bg-zinc-900 border-b border-zinc-800 p-6 flex flex-col gap-4 shadow-2xl z-50"
                        style="display: none;">
                        
                        @auth
                            {{-- Tampilan Saat Sudah Login --}}
                            <div class="flex items-center gap-3 mb-2 pb-4 border-b border-zinc-800">
                                <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center overflow-hidden">
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('storage/'.Auth::user()->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-victory" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    @endif
                                </div>
                                <div class="text-white font-bold">{{ Auth::user()->nama }}</div>
                            </div>

                            <a href="{{ route('booking.step1') }}" class="text-center w-full bg-victory text-black font-bold uppercase py-3 rounded-sm hover:bg-white hover:text-black transition-all">Order Now</a>
                            <a href="{{ route('booking.history') }}" class="text-zinc-400 font-bold uppercase text-sm hover:text-white transition-colors">History</a>
                            <a href="{{ route('profile.edit') }}" class="text-zinc-400 font-bold uppercase text-sm hover:text-white transition-colors">Profile</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="text-red-500 font-bold uppercase text-sm w-full text-left hover:text-red-400 transition-colors">Log Out</button>
                            </form>
                        @else
                            {{-- Tampilan Saat Belum Login --}}
                            <a href="{{ route('login') }}" class="text-zinc-400 font-bold uppercase text-sm hover:text-white transition-colors">Log In</a>
                            <a href="{{ route('register') }}" class="text-center w-full border border-zinc-700 text-white font-bold uppercase py-3 rounded-sm hover:bg-white hover:text-black transition-all">Create Account</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex flex-col justify-center items-center px-6 pt-20 overflow-hidden">
        
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/background.jpg') }}" class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-black/30"></div>
        </div>

        <div class="relative z-10 text-center max-w-5xl mx-auto space-y-8 animate-fade-in-up">
            
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-victory/50 bg-black/50 backdrop-blur-sm shadow-sm mb-4">
                <span class="w-2 h-2 rounded-full bg-victory animate-pulse"></span>
                <span class="text-white font-bold tracking-[0.3em] uppercase text-[10px]">Premium Rental Service</span>
            </div>
            
            <div class="space-y-2">
                <h1 class="text-6xl md:text-9xl font-black text-white uppercase leading-none tracking-tighter drop-shadow-lg">
                    MAKE IT
                </h1>
                <h1 class="text-6xl md:text-9xl font-black text-victory uppercase leading-none tracking-tighter drop-shadow-lg">
                    EASY
                </h1>
            </div>
            
            <p class="text-zinc-300 text-sm md:text-lg max-w-xl mx-auto leading-relaxed font-medium tracking-wide drop-shadow-md">
                Ride the Victory. Experience Semarang with style, comfort, and zero hassle.
            </p>

            <div class="pt-8">
                <a href="{{ route('booking.step1') }}" class="group relative inline-flex items-center gap-4 px-10 py-5 bg-victory text-black font-black uppercase tracking-[0.2em] text-xs rounded-sm overflow-hidden hover:scale-105 transition-transform duration-300 shadow-[0_0_20px_rgba(244,224,109,0.5)]">
                    <span class="relative z-10 flex items-center gap-3">
                        Start Booking
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </span>
                    <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/40 to-transparent z-0"></div>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white border-t border-zinc-200 py-20 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
            
            <div class="space-y-4 group">
                <div class="w-12 h-12 bg-zinc-100 border border-zinc-200 rounded-lg flex items-center justify-center text-zinc-900 group-hover:bg-victory group-hover:text-black transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-zinc-900 font-black uppercase tracking-wider text-lg">Verified Fleet</h4>
                <p class="text-zinc-500 text-sm leading-relaxed">All motorcycles are regularly serviced and maintained to ensure your safety.</p>
            </div>

            <div class="space-y-4 group">
                <div class="w-12 h-12 bg-zinc-100 border border-zinc-200 rounded-lg flex items-center justify-center text-zinc-900 group-hover:bg-victory group-hover:text-black transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-zinc-900 font-black uppercase tracking-wider text-lg">Instant Booking</h4>
                <p class="text-zinc-500 text-sm leading-relaxed">Book in minutes. Real-time availability check and instant confirmation.</p>
            </div>

            <div class="space-y-4 group">
                <div class="w-12 h-12 bg-zinc-100 border border-zinc-200 rounded-lg flex items-center justify-center text-zinc-900 group-hover:bg-victory group-hover:text-black transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h4 class="text-zinc-900 font-black uppercase tracking-wider text-lg">24/7 Support</h4>
                <p class="text-zinc-500 text-sm leading-relaxed">We are here to help you anytime, anywhere during your rental period.</p>
            </div>

        </div>
        
        <div class="mt-20 pt-8 border-t border-zinc-200 text-center">
            <p class="text-xs text-zinc-400 uppercase tracking-widest">&copy; {{ date('Y') }} Victory Motor Semarang.</p>
        </div>
    </div>

</body>
</html>