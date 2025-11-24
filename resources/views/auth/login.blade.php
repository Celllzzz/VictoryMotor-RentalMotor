<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="text-2xl font-bold text-white text-center mb-6 tracking-wide">WELCOME BACK</h2>

        <div>
            <label for="email" class="block font-medium text-sm text-gray-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-md shadow-sm input-dark focus:ring-0" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300">Password</label>
            <input id="password" class="block mt-1 w-full rounded-md shadow-sm input-dark focus:ring-0"
                            type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-zinc-700 bg-zinc-900 text-yellow-500 shadow-sm focus:ring-yellow-500" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-400 hover:text-victory rounded-md focus:outline-none transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif

            <button type="submit" class="ms-3 inline-flex items-center px-6 py-2 bg-victory border border-transparent rounded-sm font-bold text-xs text-black uppercase tracking-widest hover:bg-white focus:bg-white active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Log in') }}
            </button>
        </div>
        
        <div class="mt-6 text-center border-t border-white/10 pt-4">
            <p class="text-sm text-gray-500">Don't have an account? 
                <a href="{{ route('register') }}" class="text-victory hover:text-white font-bold transition-colors">Sign Up Now</a>
            </p>
        </div>
    </form>
</x-guest-layout>