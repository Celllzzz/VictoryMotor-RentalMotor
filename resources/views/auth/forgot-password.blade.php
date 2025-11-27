<x-guest-layout>
    <div class="max-w-md mx-auto bg-white border border-zinc-200 rounded-xl shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="bg-black px-8 py-6 border-b-4 border-victory">
            <h2 class="text-white font-black uppercase tracking-widest text-xl">Password Recovery</h2>
            <p class="text-victory text-[10px] font-bold uppercase tracking-wide mt-1">Reset your account access</p>
        </div>

        <div class="p-8">
            <div class="mb-6 text-xs font-medium text-zinc-500 leading-relaxed">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Email Address</label>
                    <input type="email" name="email" :value="old('email')" required autofocus
                           class="w-full bg-zinc-50 border border-zinc-200 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold text-zinc-900 transition-all placeholder-zinc-300"
                           placeholder="name@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="w-full px-6 py-3 bg-black text-white font-black uppercase tracking-widest rounded-lg hover:bg-victory hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        {{ __('Send Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>