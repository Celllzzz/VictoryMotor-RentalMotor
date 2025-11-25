<x-app-layout>
    <x-slot name="header">Start Booking</x-slot>

    <div class="max-w-3xl mx-auto animate-fade-in-up">
        
        <div class="flex items-center justify-center mb-12">
            <div class="relative flex flex-col items-center group cursor-default">
                <div class="w-10 h-10 bg-victory text-black rounded-full flex items-center justify-center font-black border-4 border-black z-10 shadow-lg transition-transform group-hover:scale-110">1</div>
                <span class="absolute -bottom-6 text-[10px] font-bold uppercase tracking-widest text-black">Dates</span>
            </div>
            <div class="h-1 w-24 bg-zinc-200 mx-2 rounded-full overflow-hidden">
                <div class="h-full bg-zinc-200 w-0"></div>
            </div>
            <div class="relative flex flex-col items-center opacity-40">
                <div class="w-10 h-10 bg-zinc-200 text-zinc-500 rounded-full flex items-center justify-center font-bold border-4 border-zinc-100">2</div>
                <span class="absolute -bottom-6 text-[10px] font-bold uppercase tracking-widest">Bike</span>
            </div>
            <div class="h-1 w-24 bg-zinc-200 mx-2"></div>
            <div class="relative flex flex-col items-center opacity-40">
                <div class="w-10 h-10 bg-zinc-200 text-zinc-500 rounded-full flex items-center justify-center font-bold border-4 border-zinc-100">3</div>
                <span class="absolute -bottom-6 text-[10px] font-bold uppercase tracking-widest">Finish</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-zinc-100 overflow-hidden relative group hover:shadow-2xl transition-all duration-500">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-black via-victory to-black"></div>
            
            <div class="p-10">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-black text-zinc-900 uppercase tracking-tight mb-2">When will you ride?</h2>
                    <p class="text-zinc-500 text-sm">Select your pickup and return dates to check availability.</p>
                </div>

                <form action="{{ route('booking.search') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block font-bold text-[10px] uppercase tracking-[0.2em] text-zinc-400 mb-3 group-hover:text-victory transition-colors">Pick-up Date & Time</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-zinc-400 group-hover:text-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="datetime-local" name="tgl_pinjam" required min="{{ date('Y-m-d\TH:i') }}"
                                    class="w-full bg-zinc-50 border-2 border-zinc-100 text-zinc-900 font-bold rounded-xl focus:ring-0 focus:border-black focus:bg-white pl-12 p-4 transition-all duration-300 hover:border-zinc-300">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block font-bold text-[10px] uppercase tracking-[0.2em] text-zinc-400 mb-3 group-hover:text-victory transition-colors">Return Date & Time</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-zinc-400 group-hover:text-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <input type="datetime-local" name="tgl_kembali" required
                                    class="w-full bg-zinc-50 border-2 border-zinc-100 text-zinc-900 font-bold rounded-xl focus:ring-0 focus:border-black focus:bg-white pl-12 p-4 transition-all duration-300 hover:border-zinc-300">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-5 rounded-xl font-black uppercase tracking-[0.2em] text-sm hover:bg-victory hover:text-black hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 group">
                        <span>Find Available Bikes</span>
                        <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>