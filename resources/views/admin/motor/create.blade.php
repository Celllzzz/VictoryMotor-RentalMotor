<x-admin-layout>
    @section('header', 'Add New Bike')

    <div class="max-w-4xl mx-auto">
        <a href="{{ route('admin.motor.index') }}" class="inline-flex items-center text-gray-500 hover:text-black mb-6 font-bold uppercase text-xs tracking-wider">
            &larr; Back to Fleet
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-black px-8 py-4">
                <h2 class="text-white font-black uppercase tracking-wide">Vehicle Information</h2>
            </div>
            
            {{-- Tambahkan ID "createMotorForm" agar bisa dideteksi Script --}}
            <form id="createMotorForm" action="{{ route('admin.motor.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Nama Motor --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Bike Model Name <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold" placeholder="e.g. Vario 160 ABS">
                    </div>

                    {{-- Merk --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand / Manufacturer <span class="text-red-500">*</span></label>
                        <input type="text" name="merk" value="{{ old('merk') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="e.g. Honda">
                    </div>

                    {{-- No Polisi --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">License Plate <span class="text-red-500">*</span></label>
                        <input type="text" name="no_polisi" value="{{ old('no_polisi') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-mono uppercase" placeholder="H 1234 XY">
                    </div>

                    {{-- Warna --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Color <span class="text-red-500">*</span></label>
                        <input type="text" name="warna" value="{{ old('warna') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="e.g. Matte Black">
                    </div>

                    {{-- Tahun --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Year <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_beli" value="{{ old('tahun_beli') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="2024">
                    </div>

                    {{-- Harga Sewa --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Daily Rate (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="harga_sewa" value="{{ old('harga_sewa') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 pl-10 focus:ring-victory focus:border-victory font-bold" placeholder="100000">
                        </div>
                    </div>
                </div>

                {{-- Image Upload dengan Preview --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Bike Image <span class="text-red-500">*</span></label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-victory transition-colors overflow-hidden">
                            
                            <img id="preview-image" class="absolute inset-0 w-full h-full object-cover hidden" />
                            
                            <div id="upload-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-bold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 2MB)</p>
                            </div>

                            <input id="dropzone-file" name="gambar" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                        </label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-yellow-400 shadow-lg transition-transform hover:-translate-y-1">
                        Save Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Javascript untuk Preview & Validasi Submit --}}
    <script>
        // 1. Logic Validasi Saat Submit
        document.getElementById('createMotorForm').addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Daftar field yang wajib diisi (name attribute)
            const requiredFields = {
                'nama': 'Bike Model Name',
                'merk': 'Brand / Manufacturer',
                'no_polisi': 'License Plate',
                'warna': 'Color',
                'tahun_beli': 'Year',
                'harga_sewa': 'Daily Rate'
            };

            // Loop cek input text/number
            for (const [fieldName, label] of Object.entries(requiredFields)) {
                const input = this.querySelector(`[name="${fieldName}"]`);
                if (!input || input.value.trim() === '') {
                    isValid = false;
                    errorMessage = `Please fill in the <b>${label}</b> field!`;
                    
                    // Highlight input merah (opsional)
                    input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    
                    // Hapus highlight saat user mengetik
                    input.addEventListener('input', function() {
                        this.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                    }, {once: true});

                    break; // Stop di error pertama
                }
            }

            // Cek File Gambar Terpisah
            if (isValid) {
                const fileInput = document.getElementById('dropzone-file');
                if (!fileInput.files || fileInput.files.length === 0) {
                    isValid = false;
                    errorMessage = 'Please upload a <b>Bike Image</b>!';
                }
            }

            // JIKA ADA ERROR
            if (!isValid) {
                e.preventDefault(); // Tahan form, jangan kirim ke server
                
                // Panggil Global Error Alert (yang sudah kita buat di Layout)
                if (typeof showErrorAlert === 'function') {
                    showErrorAlert(errorMessage);
                } else {
                    // Fallback jika global function belum terload
                    Swal.fire({ icon: 'error', title: 'Error!', html: errorMessage });
                }
            } 
            // JIKA SUKSES VALIDASI
            else {
                // Biarkan form submit secara alami.
                // Controller akan memproses -> Redirect -> Layout Global akan memunculkan Popup Sukses.
            }
        });

        // 2. Logic Preview Image & Validasi Size (Code sebelumnya)
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-image');
            const placeholder = document.getElementById('upload-placeholder');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB Limit

                // Validasi Size
                if (file.size > maxSize) {
                    input.value = ''; 
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    
                    if (typeof showErrorAlert === 'function') {
                        showErrorAlert('The file size exceeds the 2MB limit.');
                    } else {
                        alert('File too large!');
                    }
                    return;
                }

                // Tampilkan Preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-admin-layout>