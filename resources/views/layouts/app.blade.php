<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Victory Motor') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Color Variables */
        .text-victory { color: #F4E06D; }
        .bg-victory { background-color: #F4E06D; }
        .border-victory { border-color: #F4E06D; }
        
        /* Sidebar Styling */
        .sidebar-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
        }
        
        /* Active State: Kuning & Bold */
        .sidebar-link.active {
            background-color: #F4E06D;
            color: black;
            box-shadow: 0 4px 6px -1px rgba(244, 224, 109, 0.2);
        }
        
        /* Hover Effect: Slide kuning tipis dari kiri */
        .sidebar-link:hover:not(.active) {
            background-color: #FFF9C4; /* Kuning sangat muda */
            color: black;
            padding-left: 1.5rem; /* Animasi geser teks */
        }

        /* Smooth Transitions */
        .transition-all-300 { transition: all 0.3s ease-in-out; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out transform md:translate-x-0 md:static md:inset-0 shadow-lg"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="flex items-center justify-center h-20 border-b border-gray-100 bg-black">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto group-hover:scale-110 transition-transform">
                    <div class="flex flex-col leading-none">
                        <span class="text-white font-black uppercase tracking-wider text-sm group-hover:text-victory transition-colors">Victory</span>
                        <span class="text-victory font-bold uppercase tracking-[0.2em] text-[10px]">Motor</span>
                    </div>
                </a>
            </div>

            <nav class="flex flex-col p-4 space-y-2 mt-4">
                
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                   <span>Dashboard</span>
                </a>

                <a href="{{ route('booking.step1') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('booking.*') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                   <span>Rent a Bike</span>
                </a>

                <a href="{{ route('booking.history') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('booking.history') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                   <span>My History</span>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                   <span>My Profile</span>
                </a>
                
                <div class="border-t border-gray-200 my-4"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Sign Out</span>
                    </button>
                </form>

            </nav>
        </aside>

        <div class="flex flex-col flex-1 overflow-hidden bg-gray-50">
            
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm z-10">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none md:hidden hover:text-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <h2 class="text-xl font-extrabold text-gray-800 uppercase tracking-tight hidden md:block">
                    @yield('header', 'Dashboard')
                </h2>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-gray-900">{{ Auth::user()->nama }}</div>
                        <div class="text-[10px] font-bold text-victory uppercase bg-black px-2 py-0.5 rounded-full inline-block">Member</div>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-victory border-2 border-black flex items-center justify-center text-black font-black text-lg shadow-md">
                        {{ substr(Auth::user()->nama, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm md:hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

    </div>
</body>
</html>