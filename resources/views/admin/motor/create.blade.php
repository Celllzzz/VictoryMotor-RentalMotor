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
            
            <form action="{{ route('admin.motor.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Bike Model Name</label>
                        <input type="text" name="nama" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold" placeholder="e.g. Vario 160 ABS">
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Brand / Manufacturer</label>
                        <input type="text" name="merk" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="e.g. Honda">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">License Plate</label>
                        <input type="text" name="no_polisi" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-mono uppercase" placeholder="H 1234 XY">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Color</label>
                        <input type="text" name="warna" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="e.g. Matte Black">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Year</label>
                        <input type="number" name="tahun_beli" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="2024">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Daily Rate (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="harga_sewa" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 pl-10 focus:ring-victory focus:border-victory font-bold" placeholder="100000">
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Bike Image</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-victory transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-bold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 2MB)</p>
                            </div>
                            <input id="dropzone-file" name="gambar" type="file" class="hidden" required />
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
</x-admin-layout>