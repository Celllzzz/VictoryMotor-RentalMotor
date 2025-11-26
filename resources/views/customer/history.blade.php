<x-app-layout>
    <x-slot name="header">
        My Booking History
    </x-slot>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6 animate-fade-in-up">
        <form id="filterForm" method="GET" action="{{ route('booking.history') }}" class="flex flex-col md:flex-row gap-6 justify-between items-center">
            
            <div class="flex flex-wrap gap-3 items-center w-full md:w-auto">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-500 uppercase">Show</span>
                    <select name="per_page" class="ajax-filter bg-gray-50 border border-gray-200 text-sm font-bold rounded-lg focus:ring-[#F4E06D] focus:border-[#F4E06D] block w-18 pl-2 pr-8 py-2 cursor-pointer text-center">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                    <span class="text-xs font-bold text-gray-500 uppercase">entries</span>
                </div>

                <div class="h-8 w-px bg-gray-200 hidden md:block mx-2"></div>

                <div class="flex items-center">
                    <select name="status" class="ajax-filter bg-gray-50 border border-gray-200 text-sm rounded-lg focus:ring-[#F4E06D] focus:border-[#F4E06D] px-3 py-2 w-40 font-medium cursor-pointer">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Approved</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Completed</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>

            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg id="searchSpinner" class="hidden w-5 h-5 text-[#F4E06D] animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg id="searchIcon" class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" class="block w-full py-3 pl-12 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-[#F4E06D] focus:border-[#F4E06D] transition-all" placeholder="Search ID or Bike Name...">
            </div>
        </form>
    </div>

    <div id="table-container" class="bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden transition-opacity duration-200 animate-fade-in-up">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-600">
                <thead class="bg-black text-white uppercase text-[10px] font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-6 py-5 text-center w-16">No</th>
                        <th class="px-6 py-5">#Order ID</th>
                        <th class="px-6 py-5">Bike Info</th>
                        <th class="px-6 py-5">Schedule</th>
                        <th class="px-6 py-5">Total Price</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($pesanans as $index => $order)
                    
                    {{-- Hitung Deadline: Waktu Buat + 1 Jam --}}
                    @php
                        $isExpired = $order->status == 'pending' && $order->created_at->addHour()->isPast();
                    @endphp

                    {{-- Hover effect dihapus --}}
                    <tr class="transition-all duration-300 group">
                        <td class="px-6 py-5 text-center font-bold text-zinc-800">
                            {{ ($pesanans->currentPage() - 1) * $pesanans->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-5 font-mono text-zinc-400 font-bold text-xs">#{{ $order->id }}</td>
                        <td class="px-6 py-5">
                            <div class="font-black text-zinc-900 text-base uppercase">{{ $order->motor->nama }}</div>
                            <div class="text-[10px] font-mono text-zinc-500 bg-zinc-100 inline-block px-2 py-0.5 rounded border border-zinc-200 mt-1">{{ $order->motor->no_polisi }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col gap-1 text-xs">
                                <div class="flex justify-between w-32">
                                    <span class="uppercase font-bold text-zinc-400 text-[10px]">From</span>
                                    <span class="text-zinc-800 font-bold">{{ $order->tgl_pinjam->format('d M, H:i') }}</span>
                                </div>
                                <div class="flex justify-between w-32">
                                    <span class="uppercase font-bold text-zinc-400 text-[10px]">To</span>
                                    <span class="text-zinc-800 font-bold">{{ $order->tgl_kembali->format('d M, H:i') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-black font-black text-lg group-hover:scale-105 transition-transform origin-left">
                                Rp {{ number_format($order->total_harga) }}
                            </div>
                            <div class="text-[10px] text-zinc-400 uppercase tracking-wider font-bold mt-1">{{ $order->jenisBayar->jenis_bayar }}</div>
                        </td>
                        <td class="px-6 py-5">
                        @if($isExpired)
                            <span class="px-3 py-1.5 rounded-sm text-[10px] uppercase font-black tracking-widest border shadow-sm bg-zinc-100 text-zinc-500 border-zinc-200">
                                Expired
                            </span>
                        @else
                            <span class="px-3 py-1.5 rounded-sm text-[10px] uppercase font-black tracking-widest border shadow-sm
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : '' }}
                                {{ $order->status == 'dibayar' ? 'bg-orange-100 text-orange-700 border-orange-200' : '' }} {{ $order->status == 'disetujui' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}
                                {{ $order->status == 'selesai' ? 'bg-green-100 text-green-700 border-green-200' : '' }}
                                {{ $order->status == 'ditolak' ? 'bg-red-100 text-red-700 border-red-200' : '' }}">
                                {{ $order->status == 'dibayar' ? 'Verifying' : $order->status }}
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-5 text-center">
                        @if($isExpired)
                            <button disabled class="text-[10px] bg-zinc-200 text-zinc-400 px-4 py-2 rounded-sm font-black uppercase tracking-widest cursor-not-allowed">
                                Timeout
                            </button>
                        @elseif($order->status == 'pending')
                            <a href="{{ route('booking.payment', $order->id) }}" class="text-[10px] bg-black text-white px-4 py-2 rounded-sm hover:bg-victory hover: font-black uppercase tracking-widest transition-all hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                                Pay Now
                            </a>
                        @elseif($order->status == 'dibayar')
                            <div class="flex items-center justify-center gap-1 text-orange-500 bg-orange-50 px-2 py-1 rounded border border-orange-100 w-fit mx-auto">
                                <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                <span class="text-[10px] font-black uppercase tracking-wider">Waiting</span>
                            </div>
                        @elseif($order->status == 'disetujui')
                            <div class="flex items-center justify-center gap-1 text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100 w-fit mx-auto">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-[10px] font-black uppercase tracking-wider">Active</span>
                            </div>
                        @else
                            <span class="text-zinc-300 font-bold">-</span>
                        @endif
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center opacity-50">
                                <svg class="w-12 h-12 text-zinc-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <p class="uppercase tracking-widest text-xs font-bold text-zinc-400">No booking history yet.</p>
                                <a href="{{ url('/#booking-section') }}" class="text-[#F4E06D] hover:underline text-xs mt-2 font-bold hover:text-black transition-colors">Start your first journey</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $pesanans->links() }}
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
                // UI Loading
                tableContainer.style.opacity = '0.5';
                if(searchSpinner) searchSpinner.classList.remove('hidden');
                if(searchIcon) searchIcon.classList.add('hidden');

                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);

                fetch(`${filterForm.action}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.getElementById('table-container').innerHTML;
                    
                    tableContainer.innerHTML = newTable;
                    tableContainer.style.opacity = '1';
                    
                    if(searchSpinner) searchSpinner.classList.add('hidden');
                    if(searchIcon) searchIcon.classList.remove('hidden');
                    
                    window.history.pushState({}, '', `${filterForm.action}?${params.toString()}`);
                })
                .catch(error => console.error('Error:', error));
            }

            // Event Listener Search (Debounce)
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(fetchResults, 500); 
            });

            // Event Listener Dropdown Change
            document.querySelectorAll('.ajax-filter').forEach(select => {
                select.addEventListener('change', fetchResults);
            });
        });
    </script>
</x-app-layout>