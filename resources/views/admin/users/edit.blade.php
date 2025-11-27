<x-admin-layout>
    @section('header', 'Edit Admin')

    <div class="max-w-2xl mx-auto">
        {{-- 1. Tombol Back dengan Animasi Slide Left --}}
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center text-gray-500 font-bold uppercase text-xs tracking-wider mb-6
                  transition-all duration-300 ease-in-out
                  hover:text-black hover:-translate-x-2">
            <span class="mr-1 text-lg leading-none pb-0.5">&larr;</span> Back to List
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-black px-8 py-4">
                <h2 class="text-white font-black uppercase tracking-wide">Edit Profile: {{ $admin->nama }}</h2>
            </div>
            
            {{-- 2. Tambahkan ID Form --}}
            <form id="editAdminForm" action="{{ route('admin.users.update', $admin->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    {{-- Nama (Wajib) --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $admin->nama) }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold">
                        @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email (Wajib) --}}
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    {{-- Password Section (Opsional) --}}
                    <div class="border-t border-gray-100 my-6 pt-6">
                        <h3 class="font-bold text-gray-900 mb-4">Change Password (Optional)</h3>
                        <p class="text-xs text-gray-500 mb-4">Leave blank if you don't want to change the password.</p>

                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">New Password</label>
                            <input type="password" name="password" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="Type to change password">
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory" placeholder="Retype new password">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-victory text-black font-black uppercase tracking-widest rounded-lg hover:bg-yellow-400 shadow-lg transition-transform hover:-translate-y-1">
                        Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. Script Validasi Edit --}}
    <script>
        document.getElementById('editAdminForm').addEventListener('submit', function(e) {
            let isValid = true;
            let errorList = '';

            const nama = this.querySelector('[name="nama"]');
            const email = this.querySelector('[name="email"]');
            const password = this.querySelector('[name="password"]');
            const confirm = this.querySelector('[name="password_confirmation"]');

            // A. Validasi Field Wajib (Nama & Email)
            const requiredFields = [
                { input: nama, name: 'Full Name' },
                { input: email, name: 'Email Address' }
            ];

            requiredFields.forEach(field => {
                if (!field.input.value.trim()) {
                    isValid = false;
                    field.input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    errorList += `<li class="mb-1">Please fill in the <b>${field.name}</b> field.</li>`;
                    
                    field.input.addEventListener('input', function() {
                        this.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                    }, {once: true});
                }
            });

            // B. Validasi Password (HANYA JIKA DIISI)
            if (password.value.trim() !== '') {
                // 1. Cek Match
                if (password.value !== confirm.value) {
                    isValid = false;
                    password.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    confirm.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    errorList += `<li class="mb-1"><b>New Passwords</b> do not match!</li>`;
                    
                    // Reset listener
                    [password, confirm].forEach(el => {
                        el.addEventListener('input', function() {
                            this.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                        }, {once: true});
                    });
                }
                
                // 2. Cek Minimal Length (Optional, misal min 8)
                if (password.value.length < 8) {
                    isValid = false;
                    password.classList.add('border-red-500');
                    errorList += `<li class="mb-1">Password must be at least <b>8 characters</b>.</li>`;
                }
            }

            // C. Eksekusi
            if (!isValid) {
                e.preventDefault();
                const finalHtml = `<ul class="text-left text-sm list-none pl-2">${errorList}</ul>`;

                if (typeof showErrorAlert === 'function') {
                    showErrorAlert(finalHtml);
                } else {
                    Swal.fire({ icon: 'error', title: 'Validation Error', html: finalHtml });
                }
            }
        });
    </script>
</x-admin-layout>