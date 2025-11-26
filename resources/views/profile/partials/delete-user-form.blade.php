<section class="space-y-6">
    <header class="flex items-start gap-4">
        <div class="p-3 bg-red-50 rounded-full text-red-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <h2 class="text-lg font-black text-red-600 uppercase tracking-tight">
                {{ __('Delete Account') }}
            </h2>
            <p class="mt-1 text-sm text-zinc-500">
                {{ __('Permanently remove your account and data. This action cannot be undone.') }}
            </p>
        </div>
    </header>

    <div class="flex justify-end">
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-6 py-3 border-2 border-red-100 text-red-500 font-black uppercase tracking-widest text-[10px] rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
            {{ __('Delete Account') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-zinc-900 uppercase tracking-tight">
                {{ __('Are you sure?') }}
            </h2>

            <p class="mt-2 text-sm text-zinc-500">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <input id="password" name="password" type="password" class="block w-3/4 bg-zinc-50 border-zinc-200 text-black focus:ring-red-500 focus:border-red-500 rounded-lg py-3" placeholder="{{ __('Enter Password to Confirm') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-3 border border-zinc-200 text-zinc-600 font-bold uppercase tracking-widest text-xs rounded-lg hover:bg-zinc-50 transition-colors">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-5 py-3 bg-red-600 text-white font-black uppercase tracking-widest text-xs rounded-lg hover:bg-red-700 transition-colors shadow-lg shadow-red-500/30">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>