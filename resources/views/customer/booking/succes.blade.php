<x-app-layout>
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center">
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tight mb-2">Booking Successful!</h1>
        <p class="text-gray-500 max-w-md mx-auto mb-8">
            Pesananmu telah diterima. Silakan cek riwayat untuk melihat status dan melakukan pembayaran jika belum.
        </p>

        <div class="flex gap-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg font-bold text-gray-600 hover:border-black hover:text-black transition-colors uppercase tracking-wider">
                Back to Dashboard
            </a>
            <a href="{{ route('booking.history') }}" class="px-6 py-3 bg-victory text-black rounded-lg font-bold hover:bg-yellow-400 shadow-lg transition-colors uppercase tracking-wider">
                View History
            </a>
        </div>
    </div>
</x-app-layout>