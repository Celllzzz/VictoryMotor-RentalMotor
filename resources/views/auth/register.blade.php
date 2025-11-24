<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="text-2xl font-bold text-white text-center mb-6 tracking-wide uppercase">CREATE ACCOUNT</h2>

        <div>
            <label for="nama" class="block font-medium text-sm text-gray-300">Full Name</label>
            <input id="nama" class="block mt-1 w-full rounded-md shadow-sm input-dark focus:ring-0" 
                   type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-300">Email</label>
            <input id="email" class="block mt-1 w-full rounded-md shadow-sm input-dark focus:ring-0" 
                   type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300">Password</label>
            <input id="password" class="block mt-1 w-full rounded-md shadow-sm input-dark focus:ring-0"
                            type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Confirm Password</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-md shadow-sm input-dark focus:ring-0"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-6">
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-victory border border-transparent rounded-sm font-bold text-xs text-black uppercase tracking-widest hover:bg-white focus:bg-white active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>

        <div class="mt-6 text-center border-t border-white/10 pt-4">
            <p class="text-sm text-gray-500">Already have an account? 
                <a href="{{ route('login') }}" class="text-victory hover:text-white font-bold transition-colors">Log In Here</a>
            </p>
        </div>
    </form>
</x-guest-layout>