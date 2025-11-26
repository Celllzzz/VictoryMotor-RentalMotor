<x-app-layout>
    <div class="min-h-[80vh] flex flex-col items-center justify-center text-center px-4">
        
        <div class="mb-8 relative">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center animate-bounce">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="absolute top-0 left-0 w-full h-full bg-green-400 rounded-full opacity-20 animate-ping"></div>
        </div>

        <h1 class="text-4xl md:text-5xl font-black text-gray-900 uppercase tracking-tighter mb-4">
            Payment Received!
        </h1>
        
        <div class="max-w-md mx-auto space-y-2 text-gray-500 mb-10">
            <p class="text-lg">Thank you for making the payment.</p>
            <p class="text-sm">Our team will verify your proof of payment immediately. Please check your order status on the History page.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-sm">
            <a href="{{ route('booking.history') }}" class="flex-1 px-8 py-4 bg-black text-white font-black uppercase tracking-widest rounded-lg shadow-lg hover:bg-victory hover:transition-all transform hover:-translate-y-1 flex justify-center items-center gap-2">
                Check History
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </a>
            
            <a href="{{ url('/') }}" class="flex-1 px-8 py-4 border-2 border-gray-200 text-gray-600 font-bold uppercase tracking-widest rounded-lg hover:border-black hover:text-black transition-colors flex justify-center items-center">
                Back Home
            </a>
        </div>

    </div>
</x-app-layout>