<x-app-layout>
    @section('header', 'Choose Bike')

    <div x-data="{ selectedMotor: null, motorPrice: 0, motorName: '', motorImage: '' }">
        
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-victory text-black rounded-full flex items-center justify-center font-black border-4 border-black z-10">1</div>
                <div class="h-1 w-24 bg-black mx-2"></div>
                <div class="w-10 h-10 bg-black text-victory rounded-full flex items-center justify-center font-black border-4 border-victory z-10">2</div>
                <div class="h-1 w-24 bg-gray-300 mx-2"></div>
                <div class="w-10 h-10 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center font-bold">3</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="flex justify-between items-end mb-4">
                    <div>
                        <h2 class="text-2xl font-black uppercase">Available Bikes</h2>
                        <p class="text-gray-500 text-sm">Based on your schedule ({{ $durasiHari }} Days)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($motors as $motor)
                    <div @click="selectedMotor = {{ $motor->id }}; motorPrice = {{ $motor->harga_sewa * $durasiHari }}; motorName = '{{ $motor->nama }}'; motorImage = '{{ asset('storage/'.$motor->gambar) }}'" 
                         class="bg-white rounded-xl border-2 transition-all cursor-pointer overflow-hidden group hover:shadow-xl relative"
                         :class="selectedMotor == {{ $motor->id }} ? 'border-victory ring-2 ring-victory ring-offset-2' : 'border-transparent hover:border-gray-200'">
                        
                        <div class="h-48 bg-gray-100 overflow-hidden relative">
                            <img src="{{ asset('storage/'.$motor->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $motor->nama }}">
                            <div class="absolute top-2 right-2 bg-black text-white text-xs font-bold px-2 py-1 rounded uppercase">
                                {{ $motor->merk }}
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="font-black text-lg text-gray-900 uppercase">{{ $motor->nama }}</h3>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-3">{{ $motor->warna }} &bull; {{ $motor->tahun_beli }}</p>
                            
                            <div class="flex justify-between items-center border-t border-gray-100 pt-3">
                                <div>
                                    <span class="block text-[10px] text-gray-400 uppercase font-bold">Price / Day</span>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($motor->harga_sewa) }}</span>
                                </div>
                                
                                <button class="px-4 py-2 rounded font-bold text-xs uppercase transition-colors"
                                    :class="selectedMotor == {{ $motor->id }} ? 'bg-victory text-black' : 'bg-gray-100 text-gray-600 group-hover:bg-black group-hover:text-white'">
                                    <span x-text="selectedMotor == {{ $motor->id }} ? 'Selected' : 'Select'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500 font-bold">Tidak ada motor tersedia untuk tanggal ini.</p>
                        <a href="{{ route('booking.step1') }}" class="text-victory underline text-sm hover:text-black">Ganti Tanggal</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-1 lg:sticky lg:top-6">
                
                <div x-show="!selectedMotor" class="bg-white p-8 rounded-xl border border-gray-200 text-center shadow-sm">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Select a Bike First</h3>
                    <p class="text-sm text-gray-500 mt-2">Pilih motor di sebelah kiri untuk melanjutkan pemesanan.</p>
                </div>

                <div x-show="selectedMotor" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="bg-white rounded-xl border border-gray-200 shadow-xl overflow-hidden">
                    
                    <div class="bg-black p-4 text-white">
                        <h3 class="font-bold uppercase text-sm tracking-widest">Booking Summary</h3>
                    </div>

                    <form action="{{ route('booking.process') }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        <input type="hidden" name="id_motor" :value="selectedMotor">
                        
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                            <img :src="motorImage" class="w-16 h-16 rounded-lg object-cover bg-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Selected Bike</p>
                                <h4 class="font-black text-lg" x-text="motorName"></h4>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Upload KTP</label>
                                <input type="file" name="foto_ktp" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-victory file:text-black hover:file:bg-yellow-400 cursor-pointer">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Gender</label>
                                <select name="jk" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-victory focus:ring-victory">
                                    <option value="L">Male</option>
                                    <option value="P">Female</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Address</label>
                                <textarea name="alamat" required rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-victory focus:ring-victory" placeholder="Domisili saat ini..."></textarea>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Payment Method</label>
                            <div class="space-y-2">
                                @foreach($jenisBayar as $jb)
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-victory transition-colors">
                                    <input type="radio" name="id_jenis_bayar" value="{{ $jb->id }}" required class="text-victory focus:ring-victory border-gray-300">
                                    <span class="ml-3 font-bold text-sm text-gray-700">{{ $jb->jenis_bayar }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center mb-6">
                            <span class="text-sm font-bold text-gray-500">Total ({{ $durasiHari }} Days)</span>
                            <span class="text-2xl font-black text-black">Rp <span x-text="new Intl.NumberFormat('id-ID').format(motorPrice)"></span></span>
                        </div>

                        <button type="submit" class="w-full bg-victory text-black py-4 rounded-lg font-black uppercase tracking-widest hover:bg-yellow-400 hover:shadow-lg transition-all transform hover:-translate-y-1">
                            Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>