<section>
    <header class="flex items-start justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-black uppercase tracking-tight">
                Profile Information
            </h2>
            <p class="mt-2 text-sm text-zinc-500 font-medium">
                Update your account's profile information and email address.
            </p>
        </div>
        <div class="p-3 bg-zinc-50 rounded-full text-victory">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nama" :value="__('Full Name')" class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <x-text-input id="nama" name="nama" type="text" class="pl-12 block w-full bg-zinc-50 border-zinc-200 focus:border-black focus:ring-black rounded-xl py-3 transition-all" :value="old('nama', $user->nama)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-2" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <x-text-input id="email" name="email" type="email" class="pl-12 block w-full bg-zinc-50 border-zinc-200 focus:border-black focus:ring-black rounded-xl py-3 transition-all" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 bg-yellow-50 p-3 rounded-lg border border-yellow-100">
                    <p class="text-sm text-yellow-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="mt-2 text-xs font-bold uppercase tracking-wider text-black underline hover:text-victory transition-colors">
                        {{ __('Re-send verification email') }}
                    </button>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-8 py-3 bg-black text-white font-black uppercase tracking-widest text-xs rounded-lg hover:bg-victory hover:transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Saved
                </p>
            @endif
        </div>
    </form>
</section>