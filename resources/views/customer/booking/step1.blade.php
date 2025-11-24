<x-app-layout>
    @section('header', 'Start Booking')

    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-black text-victory rounded-full flex items-center justify-center font-black border-4 border-victory z-10">1</div>
                <div class="h-1 w-24 bg-gray-300 mx-2"></div>
                <div class="w-10 h-10 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center font-bold">2</div>
                <div class="h-1 w-24 bg-gray-300 mx-2"></div>
                <div class="w-10 h-10 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center font-bold">3</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-victory"></div>
            
            <div class="p-8">
                <h2 class="text-2xl font-black text-gray-900 uppercase mb-2">Select Dates</h2>
                <p class="text-gray-500 mb-8">Tentukan kapan kamu ingin mulai berkendara.</p>

                <form action="{{ route('booking.search') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block font-bold text-xs uppercase tracking-widest text-gray-500 mb-2">Pick-up Date & Time</label>
                            <input type="datetime-local" name="tgl_pinjam" required
                                class="w-full bg-gray-50 border border-gray-200 text-gray-900 font-bold rounded-lg focus:ring-victory focus:border-victory p-4"
                                min="{{ date('Y-m-d\TH:i') }}">
                        </div>

                        <div>
                            <label class="block font-bold text-xs uppercase tracking-widest text-gray-500 mb-2">Return Date & Time</label>
                            <input type="datetime-local" name="tgl_kembali" required
                                class="w-full bg-gray-50 border border-gray-200 text-gray-900 font-bold rounded-lg focus:ring-victory focus:border-victory p-4">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-4 rounded-lg font-black uppercase tracking-widest hover:bg-victory hover:text-black hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 group">
                        <span>Check Availability</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-6 flex items-start gap-3 text-gray-500 text-sm bg-blue-50 p-4 rounded-lg border border-blue-100">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p>Harga sewa dihitung per 24 jam. Keterlambatan pengembalian akan dikenakan biaya tambahan sesuai kebijakan Victory Motor.</p>
        </div>
    </div>
</x-app-layout>