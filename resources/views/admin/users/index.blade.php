<x-admin-layout>
    @section('header', 'Admin Management')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-gray-900 uppercase">Admin List</h1>
            <p class="text-sm text-gray-500">Manage who can access the dashboard.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
            class="group px-6 py-3 bg-black text-white font-bold uppercase tracking-wider rounded-lg 
                transition-all duration-300 ease-in-out
                hover:-translate-y-1 hover:shadow-xl 
                flex items-center gap-2">
            {{-- Ikon membesar sedikit (scale-110) saat di-hover --}}
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            New Admin
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-black text-white uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center w-12">#</th>
                        <th class="px-6 py-4">Admin Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Joined Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($admins as $loop => $admin)
                    <tr class="hover:bg-yellow-50 transition-colors">
                        <td class="px-6 py-4 text-center font-mono text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <div class="font-black text-gray-900 uppercase">{{ $admin->nama }}</div>
                            @if(auth()->id() == $admin->id)
                                <span class="text-[10px] bg-green-100 text-green-800 px-2 py-0.5 rounded font-bold uppercase">You</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $admin->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $admin->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                @if(auth()->id() != $admin->id)
                                    <form id="delete-admin-{{ $admin->id }}" action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button onclick="confirmAction('delete-admin-{{ $admin->id }}', 'Delete this admin permanently?')" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>