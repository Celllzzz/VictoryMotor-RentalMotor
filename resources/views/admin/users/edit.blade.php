<x-admin-layout>
    @section('header', 'Edit Admin')

    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-gray-500 hover:text-black mb-6 font-bold uppercase text-xs tracking-wider">
            &larr; Back to List
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-black px-8 py-4">
                <h2 class="text-white font-black uppercase tracking-wide">Edit Profile: {{ $admin->nama }}</h2>
            </div>
            
            <form action="{{ route('admin.users.update', $admin->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Full Name</label>
                        <input type="text" name="nama" value="{{ old('nama', $admin->nama) }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory font-bold">
                        @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="border-t border-gray-100 my-6 pt-6">
                        <h3 class="font-bold text-gray-900 mb-4">Change Password (Optional)</h3>
                        <p class="text-xs text-gray-500 mb-4">Leave blank if you don't want to change the password.</p>

                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">New Password</label>
                            <input type="password" name="password" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 focus:ring-victory focus:border-victory">
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
</x-admin-layout>