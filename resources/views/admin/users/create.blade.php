<x-admin-layout>
    @section('header', 'Add New Admin')

    <div class="max-w-2xl mx-auto">
        {{-- Animasi Back Button: Hover Slide Left --}}
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center text-gray-500 font-bold uppercase text-xs tracking-wider mb-6
                  transition-all duration-300 ease-in-out
                  hover:text-black hover:-translate-x-2">
            <span class="mr-1 text-lg leading-none pb-0.5">&larr;</span> Back to List
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-black px-8 py-4">
                <h2 class="text-white font-black uppercase tracking-wide">Admin Credentials</h2>
            </div>
            
            {{-- Tambahkan ID form untuk selector Javascript --}}
            <form id="createAdminForm" action="{{ route('admin.users.store') }}" method="POST" class="p-8">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Full Name <span class="text-red-500">*</span></label>
                        {{-- Hapus attribute 'required' bawaan HTML agar handle via JS --}}
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold" placeholder="e.g. John Doe">
                        @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="admin@example.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="Minimum 8 characters">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="Retype password">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-yellow-400 shadow-lg transition-transform hover:-translate-y-1">
                        Create Admin Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Validasi Form --}}
    <script>
        document.getElementById('createAdminForm').addEventListener('submit', function(e) {
            let isValid = true;
            let errorList = '';

            // Definisi Field
            const nama = this.querySelector('[name="nama"]');
            const email = this.querySelector('[name="email"]');
            const password = this.querySelector('[name="password"]');
            const confirm = this.querySelector('[name="password_confirmation"]');

            // 1. Validasi Input Kosong (Looping)
            const fields = [
                { input: nama, name: 'Full Name' },
                { input: email, name: 'Email Address' },
                { input: password, name: 'Password' },
                { input: confirm, name: 'Confirm Password' }
            ];

            fields.forEach(field => {
                if (!field.input.value.trim()) {
                    isValid = false;
                    // Highlight border merah
                    field.input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    // Tambahkan pesan error ke list HTML
                    errorList += `<li class="mb-1">Please fill in the <b>${field.name}</b> field.</li>`;
                    
                    // Hapus merah saat diketik
                    field.input.addEventListener('input', function() {
                        this.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                    }, {once: true});
                }
            });

            // 2. Validasi Password Match (Hanya jika password diisi)
            if (password.value.trim() && confirm.value.trim()) {
                if (password.value !== confirm.value) {
                    isValid = false;
                    password.classList.add('border-red-500');
                    confirm.classList.add('border-red-500');
                    errorList += `<li class="mb-1"><b>Passwords</b> do not match!</li>`;
                }
            }

            // JIKA ADA ERROR
            if (!isValid) {
                e.preventDefault(); // Stop submit
                
                // Bungkus list error dalam UL agar rapi di SweetAlert
                const finalHtml = `<ul class="text-left text-sm list-none pl-2">${errorList}</ul>`;

                // Panggil Global Function
                if (typeof showErrorAlert === 'function') {
                    showErrorAlert(finalHtml);
                } else {
                    Swal.fire({ icon: 'error', title: 'Validation Error', html: finalHtml });
                }
            }
        });
    </script>
</x-admin-layout>