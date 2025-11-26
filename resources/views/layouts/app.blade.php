<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Victory Motor') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .text-victory { color: #F4E06D; }
        .bg-victory { background-color: #F4E06D; }
        .border-victory { border-color: #F4E06D; }
        
        /* Glass Navbar (Hitam Pekat) - Disamakan dengan Landing Page */
        .glass-nav {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a1a1aa; }
        
        ::selection { background: #F4E06D; color: black; }
    </style>
</head>
<body class="font-sans antialiased bg-zinc-50 text-zinc-900 min-h-screen flex flex-col">

    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex justify-between items-center h-20">
                
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="flex flex-col leading-none">
                        <span class="text-white font-black tracking-widest text-lg uppercase group-hover:text-gray-300 transition-colors">Victory</span>
                        <span class="text-victory font-bold tracking-[0.3em] text-[10px] uppercase">Motor</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('booking.history') }}" class="text-xs font-bold uppercase tracking-[0.15em] text-zinc-400 hover:text-victory transition-colors duration-300 relative group">
                        History
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-victory transition-all duration-300 group-hover:w-full"></span>
                    </a>

                    <a href="{{ route('booking.step1') }}" class="px-6 py-2.5 bg-victory text-black font-black uppercase tracking-widest text-[10px] rounded-sm shadow-[0_0_15px_rgba(244,224,109,0.3)] hover:bg-white hover:scale-105 transition-all duration-300">
                        Order Now
                    </a>

                    <div class="h-6 w-px bg-zinc-700"></div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden lg:block">
                                <div class="text-xs font-bold text-white uppercase tracking-wider group-hover:text-victory transition-colors">{{ Auth::user()->nama }}</div>
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-zinc-800 border-2 border-zinc-700 flex items-center justify-center text-zinc-400 group-hover:border-victory group-hover:text-victory transition-all duration-300 shadow-sm overflow-hidden">
                                @if(Auth::user()->foto)
                                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @endif
                            </div>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 mt-4 w-56 bg-zinc-900 border border-zinc-700 rounded-sm shadow-2xl py-2 z-50 overflow-hidden"
                             style="display: none;">
                            
                            <div class="px-5 py-3 border-b border-zinc-800">
                                <p class="text-[10px] text-zinc-500 uppercase tracking-wider font-bold">Signed in as</p>
                                <p class="text-xs font-bold text-white truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-zinc-400 hover:bg-zinc-800 hover:text-victory transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profile Settings
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
                </div>

                <div class="md:hidden flex items-center" x-data="{ mobileOpen: false }">
                    <button @click="mobileOpen = !mobileOpen" class="text-white hover:text-victory transition-colors p-2 focus:outline-none">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <div x-show="mobileOpen" @click.away="mobileOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="absolute top-20 left-0 w-full bg-zinc-900 border-b border-zinc-800 p-6 flex flex-col gap-4 shadow-2xl z-50">
                         
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

                         <a href="{{ route('booking.step1') }}" class="text-center w-full bg-victory text-black font-bold uppercase py-3 rounded-sm">Order Now</a>
                         <a href="{{ route('booking.history') }}" class="text-zinc-400 font-bold uppercase text-sm hover:text-white transition-colors">History</a>
                         <a href="{{ route('profile.edit') }}" class="text-zinc-400 font-bold uppercase text-sm hover:text-white transition-colors">Profile</a>
                         
                         <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-red-500 font-bold uppercase text-sm w-full text-left hover:text-red-400 transition-colors">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 pt-28 px-4 md:px-8 w-full max-w-7xl mx-auto">
        @if (isset($header))
            <div class="mb-10 flex items-center gap-4">
                <div class="h-10 w-1.5 bg-victory rounded-full"></div>
                <h2 class="font-black text-3xl text-zinc-900 uppercase tracking-tighter">
                    {{ $header }}
                </h2>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="py-10 border-t border-zinc-200 bg-white mt-20">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" class="h-6 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all">
                <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Victory Motor</span>
            </div>
            <p class="text-zinc-400 text-[10px] uppercase tracking-widest">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </footer>

</body>
</html>