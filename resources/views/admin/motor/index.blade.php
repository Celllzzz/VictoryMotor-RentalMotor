<x-admin-layout>
    @section('header', 'Fleet Management')

    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 uppercase">Motorcycle Inventory</h1>
            <p class="text-sm text-gray-500">Manage fleet, pricing, and availability.</p>
        </div>
        <a href="{{ route('admin.motor.create') }}" class="px-6 py-3 bg-black text-white font-bold uppercase tracking-wider rounded-lg hover:bg-victory hover: transition-all shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New Bike
        </a>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form id="filterForm" method="GET" action="{{ route('admin.motor.index') }}" class="flex flex-col md:flex-row gap-6 justify-between items-center">
            
            <div class="flex flex-wrap gap-3 items-center w-full md:w-auto">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-500 uppercase">Show</span>
                    <select name="per_page" class="ajax-filter bg-gray-50 border border-gray-200 text-sm font-bold rounded-lg focus:ring-victory focus:border-victory block w-18 pl-2 pr-8 py-2 cursor-pointer form-select text-center">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <span class="text-xs font-bold text-gray-500 uppercase">entries</span>
                </div>

                <div class="h-8 w-px bg-gray-200 hidden md:block mx-2"></div>

                <div class="flex items-center">
                    <select name="status" class="ajax-filter bg-gray-50 border border-gray-200 text-sm rounded-lg focus:ring-victory focus:border-victory px-3 py-2 w-36 font-medium cursor-pointer">
                        <option value="">All Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Available</option>
                        <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Rented</option>
                    </select>
                </div>
            </div>

            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg id="searchSpinner" class="hidden w-5 h-5 text-victory animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg id="searchIcon" class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" class="block w-full py-3 pl-12 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-victory focus:border-victory transition-all" placeholder="Type to search...">
            </div>
        </form>
    </div>

    <div id="table-container" class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden transition-opacity duration-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-black text-white uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center w-12">#</th>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Bike Details</th>
                        <th class="px-6 py-4">License Plate</th>
                        <th class="px-6 py-4">Price / Day</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($motors as $index => $motor)
                    <tr class="hover:bg-yellow-50 transition-colors group">
                        <td class="px-6 py-4 text-center font-mono text-gray-500">
                            {{ ($motors->currentPage() - 1) * $motors->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-12 w-20 rounded overflow-hidden bg-gray-100 border">
                                <img src="{{ filter_var($motor->gambar, FILTER_VALIDATE_URL) ? $motor->gambar : asset('storage/'.$motor->gambar) }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-black text-gray-900 uppercase">{{ $motor->nama }}</div>
                            <div class="text-xs font-bold text-gray-500 uppercase">{{ $motor->merk }} &bull; {{ $motor->tahun_beli }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded text-gray-700 font-bold">{{ $motor->no_polisi }}</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($motor->harga_sewa) }}</td>
                        <td class="px-6 py-4">
                            @if($motor->status == 'tersedia')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Available</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Rented</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.motor.edit', $motor->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                <form id="delete-form-{{ $motor->id }}" action="{{ route('admin.motor.destroy', $motor->id) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form>
                                <button onclick="confirmAction('delete-form-{{ $motor->id }}', 'Delete this bike permanently?')" class="p-2 text-red-600 hover:bg-red-50 rounded transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No bikes found matching your search.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $motors->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            const tableContainer = document.getElementById('table-container');
            const searchSpinner = document.getElementById('searchSpinner');
            const searchIcon = document.getElementById('searchIcon');
            let timeout = null;

            function fetchResults() {
                // Efek Loading
                tableContainer.style.opacity = '0.5';
                searchSpinner.classList.remove('hidden');
                searchIcon.classList.add('hidden');

                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);

                fetch(`${filterForm.action}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    // Parse hasil HTML baru
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.getElementById('table-container').innerHTML;
                    
                    // Ganti isi tabel lama dengan yang baru
                    tableContainer.innerHTML = newTable;
                    
                    // Kembalikan efek visual
                    tableContainer.style.opacity = '1';
                    searchSpinner.classList.add('hidden');
                    searchIcon.classList.remove('hidden');
                    
                    // Update URL browser tanpa refresh (agar kalau di-refresh filternya tetap ada)
                    window.history.pushState({}, '', `${filterForm.action}?${params.toString()}`);
                })
                .catch(error => console.error('Error:', error));
            }

            // 1. Event Listener untuk Search (Debounce 500ms)
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(fetchResults, 500); // Tunggu 500ms setelah berhenti mengetik
            });

            // 2. Event Listener untuk Dropdown Filter (Langsung update)
            document.querySelectorAll('.ajax-filter').forEach(select => {
                select.addEventListener('change', fetchResults);
            });
        });
    </script>
</x-admin-layout>