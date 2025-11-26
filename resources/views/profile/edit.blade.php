<x-dynamic-component :component="Auth::user()->role === 'admin' ? 'admin-layout' : 'app-layout'">
    <x-slot name="header">
        Account Settings
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 order-1 p-8 bg-white shadow-xl rounded-2xl border border-zinc-100 relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-victory"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-victory/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    
                    <div class="relative z-10">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="lg:col-span-1 lg:row-span-2 order-2 h-fit p-8 bg-zinc-900 text-white shadow-2xl rounded-2xl border border-zinc-800 relative overflow-hidden">
                    <div class="absolute bottom-0 right-0 w-64 h-64 bg-zinc-800/50 rounded-full blur-3xl -mr-20 -mb-20"></div>
                    
                    <div class="relative z-10">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="lg:col-span-2 order-3 p-8 bg-white shadow-lg rounded-2xl border border-red-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
                    <div class="relative z-10">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-dynamic-component>