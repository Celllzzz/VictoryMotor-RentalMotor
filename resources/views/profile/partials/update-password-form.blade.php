<section>
    <header class="mb-8 border-b border-zinc-800 pb-4">
        <h2 class="text-xl font-black text-white uppercase tracking-tight flex items-center gap-2">
            <svg class="w-5 h-5 text-victory" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            {{ __('Security') }}
        </h2>
        <p class="mt-2 text-sm text-zinc-400">
            {{ __('Update your password to keep your account secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Current Password')" class="text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2" />
            <input id="current_password" name="current_password" type="password" class="block w-full bg-zinc-800 border-zinc-700 text-white focus:border-victory focus:ring-victory rounded-xl py-3 transition-all placeholder-zinc-600" placeholder="••••••••" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2" />
            <input id="password" name="password" type="password" class="block w-full bg-zinc-800 border-zinc-700 text-white focus:border-victory focus:ring-victory rounded-xl py-3 transition-all placeholder-zinc-600" placeholder="Min. 8 characters" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2" />
            <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full bg-zinc-800 border-zinc-700 text-white focus:border-victory focus:ring-victory rounded-xl py-3 transition-all placeholder-zinc-600" placeholder="••••••••" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="w-full py-3 bg-victory text-black font-black uppercase tracking-widest text-xs rounded-lg hover:bg-white transition-all shadow-lg hover:shadow-victory/20 transform hover:-translate-y-1">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-500 font-bold absolute -bottom-8 left-0">
                    {{ __('Password updated.') }}
                </p>
            @endif
        </div>
    </form>
</section>