<x-guest-layout>
    <div class="max-w-md mx-auto bg-white border border-zinc-200 rounded-xl shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="bg-black px-8 py-6 border-b-4 border-victory flex items-center justify-between">
            <div>
                <h2 class="text-white font-black uppercase tracking-widest text-xl">Verify Email</h2>
                <p class="text-victory text-[10px] font-bold uppercase tracking-wide mt-1">Action Required</p>
            </div>
            <div class="bg-zinc-800 p-2 rounded-full">
                <svg class="w-6 h-6 text-victory" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <div class="p-8">
            <div class="mb-6 text-xs font-medium text-zinc-500 leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="text-xs font-bold text-green-700 leading-relaxed">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                </div>
            @endif

            <div class="mt-8 flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-black hover:text-white shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-xs font-bold text-zinc-400 uppercase tracking-widest hover:text-red-500 transition-colors">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>