<x-app-layout>
    <x-slot name="header">Select Your Bike</x-slot>

    <div x-data="{ selectedMotor: null, motorPrice: 0, motorName: '', motorImage: '' }" class="animate-fade-in-up">
        
        <div class="flex items-center justify-center mb-12">
            <div class="relative flex flex-col items-center opacity-60">
                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold border-4 border-black">1</div>
                <span class="absolute -bottom-6 text-[10px] font-bold uppercase tracking-widest text-zinc-400">Dates</span>
            </div>
            <div class="h-1 w-24 bg-black mx-2 rounded-full"></div>
            <div class="relative flex flex-col items-center">
                <div class="w-10 h-10 bg-victory text-black rounded-full flex items-center justify-center font-black border-4 border-black z-10 shadow-[0_0_15px_rgba(244,224,109,0.6)]">2</div>
                <span class="absolute -bottom-6 text-[10px] font-bold uppercase tracking-widest text-black">Bike</span>
            </div>
            <div class="h-1 w-24 bg-zinc-200 mx-2 rounded-full">
                <div class="h-full bg-zinc-200 w-0"></div>
            </div>
            <div class="relative flex flex-col items-center opacity-40">
                <div class="w-10 h-10 bg-zinc-200 text-zinc-500 rounded-full flex items-center justify-center font-bold border-4 border-zinc-100">3</div>
                <span class="absolute -bottom-6 text-[10px] font-bold uppercase tracking-widest">Finish</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2">
                <div class="flex items-end justify-between mb-6">
                    <h3 class="text-xl font-black uppercase tracking-tight text-zinc-900">Available Options</h3>
                    <span class="text-xs font-bold bg-zinc-100 px-3 py-1 rounded-full text-zinc-500 uppercase">{{ count($motors) }} Units Ready</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($motors as $motor)
                    <div @click="selectedMotor = {{ $motor->id }}; motorPrice = {{ $motor->harga_sewa * $durasiHari }}; motorName = '{{ $motor->nama }}'; motorImage = '{{ asset('storage/'.$motor->gambar) }}'" 
                         class="group bg-white rounded-2xl border-2 transition-all duration-300 cursor-pointer overflow-hidden hover:shadow-2xl hover:-translate-y-1.5"
                         :class="selectedMotor == {{ $motor->id }} ? 'border-victory ring-4 ring-victory/20 scale-[1.02]' : 'border-transparent hover:border-zinc-200'">
                        
                        <div class="h-52 bg-zinc-50 relative overflow-hidden">
                            <img src="{{ asset('storage/'.$motor->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-3 right-3 bg-black/80 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1.5 rounded uppercase tracking-widest shadow-lg">
                                {{ $motor->merk }}
                            </div>
                            <div class="absolute inset-0 bg-victory/20 backdrop-blur-[2px] flex items-center justify-center opacity-0 transition-opacity duration-300"
                                 :class="selectedMotor == {{ $motor->id }} ? 'opacity-100' : ''">
                                 <div class="bg-black text-victory px-4 py-2 rounded font-black uppercase tracking-widest shadow-xl transform scale-110">Selected</div>
                            </div>
                        </div>

                        <div class="p-6 relative">
                            <h3 class="font-black text-lg text-zinc-900 uppercase leading-tight mb-1">{{ $motor->nama }}</h3>
                            <p class="text-xs font-bold text-zinc-400 uppercase tracking-wide mb-4">{{ $motor->warna }} &bull; {{ $motor->tahun_beli }}</p>
                            
                            <div class="flex justify-between items-end border-t border-zinc-100 pt-4">
                                <div>
                                    <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Rate / Day</p>
                                    <p class="text-xl font-black text-zinc-900 group-hover:text-victory transition-colors">Rp {{ number_format($motor->harga_sewa) }}</p>
                                </div>
                                <div class="h-8 w-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-400 group-hover:bg-black group-hover:text-white transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 py-20 text-center bg-white rounded-2xl border-2 border-dashed border-zinc-200">
                        <div class="inline-block p-4 bg-zinc-50 rounded-full mb-3">
                            <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-zinc-400 font-bold uppercase tracking-wide text-xs">No bikes available for this date.</p>
                        <a href="{{ url('/#booking-section') }}" class="text-victory hover:text-black hover:underline text-xs mt-2 inline-block font-black uppercase tracking-wider">Change Dates</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-1 lg:sticky lg:top-32">
                
                <div x-show="!selectedMotor" class="bg-white p-10 rounded-2xl border border-zinc-200 text-center shadow-sm border-dashed">
                    <div class="w-16 h-16 bg-zinc-50 rounded-full flex items-center justify-center mx-auto mb-4 text-zinc-300 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="font-bold text-zinc-800 uppercase tracking-wide text-xs">Selection Required</h3>
                    <p class="text-xs text-zinc-400 mt-1">Choose a bike on the left.</p>
                </div>

                <div x-show="selectedMotor" 
                     x-transition:enter="transition ease-out duration-500" 
                     x-transition:enter-start="opacity-0 translate-y-10 scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-zinc-100 ring-1 ring-black/5">
                    
                    <div class="bg-black p-5 flex justify-between items-center">
                        <h3 class="font-black text-white uppercase text-xs tracking-[0.2em]">Booking Details</h3>
                        <div class="w-2 h-2 rounded-full bg-victory animate-pulse"></div>
                    </div>

                    <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="id_motor" :value="selectedMotor">
                        
                        <div class="flex items-center gap-4 pb-6 border-b border-zinc-100">
                            <img :src="motorImage" class="w-14 h-14 rounded-lg object-cover bg-zinc-100 ring-1 ring-zinc-200">
                            <div>
                                <p class="text-[10px] text-zinc-400 uppercase font-bold tracking-widest">Selected Unit</p>
                                <h4 class="font-black text-base text-zinc-900 uppercase leading-none mt-1" x-text="motorName"></h4>
                            </div>
                        </div>

                        <div class="space-y-4">
                            
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-1 tracking-wider">NIK (National ID)</label>
                                <input type="text" name="nik" required maxlength="16" minlength="16" pattern="\d{16}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
                                    placeholder="16 Digit Number"
                                    class="w-full bg-zinc-50 border-zinc-200 rounded-lg text-sm font-bold focus:border-black focus:ring-0 placeholder-zinc-300">
                                <p class="text-[9px] text-zinc-400 mt-1">*Must be exactly 16 digits.</p>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Gender</label>
                                <div class="grid grid-cols-2 gap-3">
                                    
                                    <label class="relative flex items-center justify-center p-3 border border-zinc-200 overflow-hidden rounded-lg cursor-pointer transition-all duration-300 group hover:border-black hover:shadow-md">
                                        <input type="radio" name="jk" value="L" class="peer hidden" required {{ old('jk') == 'L' ? 'checked' : '' }}>
                                        
                                        <div class="absolute inset-0 bg-victory transition-transform duration-300 origin-bottom scale-y-0 peer-checked:scale-y-100"></div>
                                        
                                        <span class="relative z-10 font-bold text-xs uppercase tracking-wide text-zinc-600 transition-colors duration-300 group-hover:text-black peer-checked:text-black flex items-center gap-2">
                                            <span>Male (L)</span>
                                            <svg class="w-4 h-4 opacity-0 -translate-x-2 peer-checked:opacity-100 peer-checked:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </span>
                                    </label>

                                    <label class="relative flex items-center justify-center p-3 border border-zinc-200 overflow-hidden rounded-lg cursor-pointer transition-all duration-300 group hover:border-black hover:shadow-md">
                                        <input type="radio" name="jk" value="P" class="peer hidden" required {{ old('jk') == 'P' ? 'checked' : '' }}>
                                        
                                        <div class="absolute inset-0 bg-victory transition-transform duration-300 origin-bottom scale-y-0 peer-checked:scale-y-100"></div>
                                        
                                        <span class="relative z-10 font-bold text-xs uppercase tracking-wide text-zinc-600 transition-colors duration-300 group-hover:text-black peer-checked:text-black flex items-center gap-2">
                                            <span>Female (P)</span>
                                            <svg class="w-4 h-4 opacity-0 -translate-x-2 peer-checked:opacity-100 peer-checked:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </span>
                                    </label>

                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-1 tracking-wider">Upload ID (KTP)</label>
                                <input type="file" name="foto_ktp" required accept="image/*" class="w-full text-[10px] text-zinc-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-zinc-100 file:text-zinc-800 hover:file:bg-victory hover:file:text-black cursor-pointer bg-zinc-50 rounded-lg border border-zinc-200">
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-1 tracking-wider">Current Address</label>
                                <textarea name="alamat" required rows="2" class="w-full bg-zinc-50 border-zinc-200 rounded-lg text-sm font-medium focus:border-black focus:ring-0 placeholder-zinc-300 resize-none" placeholder="Full address..."></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Payment Via</label>
                                <div class="space-y-2">
                                    @foreach($jenisBayar as $jb)
                                    <label class="flex items-center p-3 border border-zinc-200 bg-white rounded-lg cursor-pointer hover:border-black hover:bg-zinc-50 transition-all group">
                                        <input type="radio" name="id_jenis_bayar" value="{{ $jb->id }}" required class="text-black focus:ring-black bg-zinc-100 border-zinc-300">
                                        <span class="ml-3 font-bold text-xs uppercase tracking-wide text-zinc-600 group-hover:text-black">{{ $jb->jenis_bayar }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 bg-zinc-50 -mx-6 -mb-6 p-6 border-t border-zinc-100">
                            <div class="flex justify-between items-end mb-4">
                                <div class="text-zinc-400 text-[10px] font-bold uppercase tracking-wider">
                                    Total for <span class="text-black">{{ $durasiHari }} Days</span>
                                </div>
                                <div class="text-2xl font-black text-black leading-none">
                                    Rp <span x-text="new Intl.NumberFormat('id-ID').format(motorPrice)"></span>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-4 bg-victory text-black font-black uppercase tracking-[0.2em] text-xs rounded-lg hover:bg-black hover:text-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                Confirm & Pay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>