<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'Victory Motor') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Alert Success
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                background: '#fff',
                iconColor: '#F4E06D',
                confirmButtonColor: '#000',
                reverseButtons: true
            });
        @endif

        // Alert Error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#000',
                reverseButtons: true,
            });
        @endif

        // Konfirmasi Delete/Action (Global Function)
        function confirmAction(formId, message = 'Are you sure?') {
            Swal.fire({
                title: 'Confirmation',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F4E06D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                color: '#000',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .text-victory { color: #F4E06D; }
        .bg-victory { background-color: #F4E06D; }
        
        /* Sidebar Link Style */
        .sidebar-link {
            transition: all 0.3s ease;
            position: relative;
            font-weight: 600;
        }
        .sidebar-link.active {
            background-color: #F4E06D;
            color: black;
            box-shadow: 0 4px 6px -1px rgba(244, 224, 109, 0.2);
        }
        .sidebar-link:hover:not(.active) {
            background-color: #FFF9C4;
            color: black;
            padding-left: 1.25rem;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out transform md:translate-x-0 md:static md:inset-0 shadow-xl"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="flex items-center justify-center h-20 bg-black text-white border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <div class="flex flex-col leading-none">
                        <span class="font-black uppercase tracking-wider text-sm">Victory</span>
                        <span class="text-victory font-bold uppercase tracking-[0.2em] text-[10px]">Admin</span>
                    </div>
                </a>
            </div>

            <nav class="flex flex-col p-4 space-y-2 mt-4">
                
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Main Menu</p>

                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                   <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.transaksi.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                   <span>Transactions</span>
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-widest mt-6 mb-2">Inventory</p>

                <a href="{{ route('admin.motor.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('admin.motor.*') ? 'active' : '' }}">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                   <span>Manage Bikes</span>
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-widest mt-6 mb-2">Users & Access</p>

                <a href="{{ route('admin.users.index') }}" 
                    class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Manage Admins</span>
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

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-xl font-extrabold text-gray-800 uppercase tracking-tight">@yield('header', 'Admin Dashboard')</h2>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-gray-900">Administrator</div>
                        <div class="text-[10px] font-bold text-green-600 uppercase bg-green-100 px-2 py-0.5 rounded-full inline-block">Online</div>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-black text-victory border-2 border-victory flex items-center justify-center font-bold">
                        A
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm md:hidden"></div>
    </div>
</body>
</html>