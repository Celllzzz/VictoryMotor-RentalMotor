<x-admin-layout>
    @section('header', 'Edit Bike')

    <div class="max-w-4xl mx-auto">
        <a href="{{ route('admin.motor.index') }}" class="inline-flex items-center text-gray-500 hover:text-black mb-6 font-bold uppercase text-xs tracking-wider">
            &larr; Cancel Editing
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-black px-8 py-4 flex justify-between items-center">
                <h2 class="text-white font-black uppercase tracking-wide">Edit: {{ $motor->nama }}</h2>
            </div>
            
            <form action="{{ route('admin.motor.update', $motor->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Bike Model Name</label>
                        <input type="text" name="nama" value="{{ $motor->nama }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold">
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand</label>
                        <input type="text" name="merk" value="{{ $motor->merk }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">License Plate</label>
                        <input type="text" name="no_polisi" value="{{ $motor->no_polisi }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-mono uppercase">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Color</label>
                        <input type="text" name="warna" value="{{ $motor->warna }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Year</label>
                        <input type="number" name="tahun_beli" value="{{ $motor->tahun_beli }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Daily Rate (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="harga_sewa" value="{{ $motor->harga_sewa }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 pl-10 focus:ring-victory focus:border-victory font-bold">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Current Image</label>
                    <img src="{{ filter_var($motor->gambar, FILTER_VALIDATE_URL) ? $motor->gambar : asset('storage/'.$motor->gambar) }}" class="h-32 rounded-lg border border-gray-200">
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Change Image</label>
                    
                    <div class="flex items-center gap-6">
                        <div class="w-32 h-32 rounded-lg border border-gray-200 overflow-hidden bg-gray-50 relative">
                            <img id="edit-preview" 
                                src="{{ filter_var($motor->gambar, FILTER_VALIDATE_URL) ? $motor->gambar : asset('storage/'.$motor->gambar) }}" 
                                class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1">
                            <input type="file" name="gambar" accept="image/*" onchange="previewEditImage(event)"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-victory hover:file:text-black transition-colors cursor-pointer"/>
                            <p class="text-xs text-gray-400 mt-2">Leave blank to keep current image. Max 2MB.</p>
                            
                            @error('gambar')
                                <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <script>
                    function previewEditImage(event) {
                        const input = event.target;
                        const preview = document.getElementById('edit-preview');

                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-yellow-400 shadow-lg">
                        Update Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>