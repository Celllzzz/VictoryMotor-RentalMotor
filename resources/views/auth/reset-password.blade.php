<x-guest-layout>
    <div class="max-w-md mx-auto bg-white border border-zinc-200 rounded-xl shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="bg-black px-8 py-6 border-b-4 border-victory">
            <h2 class="text-white font-black uppercase tracking-widest text-xl">Set New Password</h2>
            <p class="text-victory text-[10px] font-bold uppercase tracking-wide mt-1">Secure your account</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-4">
                    <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Email Address</label>
                    <input type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"
                           class="w-full bg-zinc-50 border border-zinc-200 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold text-zinc-900 transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">New Password</label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="w-full bg-zinc-50 border border-zinc-200 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold text-zinc-900 transition-all"
                           placeholder="Minimum 8 characters">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Confirm Password</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full bg-zinc-50 border border-zinc-200 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold text-zinc-900 transition-all"
                           placeholder="Retype new password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="w-full px-6 py-3 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-black hover:text-white shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>