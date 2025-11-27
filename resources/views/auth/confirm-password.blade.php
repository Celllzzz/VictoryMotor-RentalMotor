<x-guest-layout>
    <div class="max-w-md mx-auto bg-white border border-zinc-200 rounded-xl shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="bg-black px-8 py-6 border-b-4 border-victory">
            <h2 class="text-white font-black uppercase tracking-widest text-xl">Secure Area</h2>
            <p class="text-victory text-[10px] font-bold uppercase tracking-wide mt-1">Password Confirmation Required</p>
        </div>

        <div class="p-8">
            <div class="mb-6 text-xs font-medium text-zinc-500 leading-relaxed bg-zinc-50 p-4 rounded-lg border border-zinc-100">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full bg-zinc-50 border border-zinc-200 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold text-zinc-900 transition-all placeholder-zinc-300"
                           placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="w-full px-6 py-3 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-black hover:text-white shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-transparent hover:border-victory">
                        {{ __('Confirm Access') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>