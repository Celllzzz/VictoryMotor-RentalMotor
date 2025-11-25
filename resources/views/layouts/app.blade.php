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
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a1a1aa; }
    </style>
</head>
<body class="font-sans antialiased bg-zinc-50 text-zinc-900 min-h-screen flex flex-col selection:bg-victory selection:text-black">

    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-zinc-200 transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex justify-between items-center h-20">
                
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="flex flex-col leading-none">
                        <span class="text-black font-black tracking-widest text-lg uppercase">Victory</span>
                        <span class="text-victory font-bold tracking-[0.3em] text-[10px] uppercase">Motor</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    
                    <a href="{{ route('booking.history') }}" class="text-xs font-bold uppercase tracking-[0.15em] text-zinc-500 hover:text-black transition-colors duration-300 relative group">
                        History
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-victory transition-all duration-300 group-hover:w-full"></span>
                    </a>

                    <a href="{{ url('/booking') }}" class="px-6 py-2.5 bg-black text-white font-black uppercase tracking-widest text-[10px] rounded shadow-lg hover:bg-victory hover:text-black hover:-translate-y-0.5 transition-all duration-300">
                        Order Now
                    </a>

                    <div class="h-6 w-px bg-zinc-200"></div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden lg:block">
                                <div class="text-xs font-bold text-black uppercase tracking-wider group-hover:text-victory transition-colors">{{ Auth::user()->nama }}</div>
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-zinc-100 border-2 border-zinc-200 flex items-center justify-center text-zinc-400 group-hover:border-victory group-hover:text-victory transition-all duration-300 shadow-sm overflow-hidden">
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
                             class="absolute right-0 mt-4 w-56 bg-white border border-zinc-100 rounded-xl shadow-2xl py-2 z-50 overflow-hidden"
                             style="display: none;">
                            
                            <div class="px-5 py-3 border-b border-zinc-100 bg-zinc-50/50">
                                <p class="text-[10px] text-zinc-400 uppercase tracking-wider font-bold">Logged in as</p>
                                <p class="text-sm font-bold text-zinc-800 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-zinc-600 hover:bg-victory/10 hover:text-black transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profile Settings
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="md:hidden flex items-center">
                    <button class="text-zinc-800 hover:text-victory transition-colors p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
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