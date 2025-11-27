<x-admin-layout>
    @section('header', 'Transaction Management')

    <div class="mb-6">
        <h1 class="text-2xl font-black text-gray-900 uppercase">Transaction Management</h1>
        <p class="text-sm text-gray-500">Monitor orders, verify payments, and manage bike returns.</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form id="filterForm" method="GET" action="{{ route('admin.transaksi.index') }}" class="flex flex-col md:flex-row gap-6 justify-between items-center">
            
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
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Active</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Completed</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Rejected</option>
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
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" class="block w-full py-3 pl-12 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-victory focus:border-victory transition-all" placeholder="Search Order ID, Name...">
            </div>
        </form>
    </div>

    <div id="table-container" class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden transition-opacity duration-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-black text-white uppercase text-xs font-bold tracking-wider">
                    <tr>
                        {{-- 1. Tambah Header Kolom No --}}
                        <th class="px-6 py-4 w-12">No</th>
                        <th class="px-6 py-4">#Order ID</th>
                        <th class="px-6 py-4">Customer Info</th>
                        <th class="px-6 py-4">Bike Details</th>
                        <th class="px-6 py-4">Date & Duration</th>
                        <th class="px-6 py-4">Total & Proof</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesanans as $order)
                    <tr class="hover:bg-yellow-50 transition-colors group">
                        
                        {{-- 2. Tambah Body Kolom No (Support Pagination) --}}
                        <td class="px-6 py-4 font-bold text-gray-700">
                            {{ $pesanans->firstItem() + $loop->index }}
                        </td>

                        <td class="px-6 py-4 font-mono text-gray-500 font-bold">#{{ $order->id }}</td>
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $order->pemesan->nama }}</div>
                            <div class="text-xs text-gray-500 truncate w-32" title="{{ $order->pemesan->alamat }}">{{ $order->pemesan->alamat }}</div>
                            <div class="mt-1">
                                @if($order->pemesan->foto_ktp)
                                    <a href="{{ filter_var($order->pemesan->foto_ktp, FILTER_VALIDATE_URL) ? $order->pemesan->foto_ktp : asset('storage/'.$order->pemesan->foto_ktp) }}" 
                                       target="_blank" class="text-[10px] text-blue-600 hover:underline font-bold flex items-center gap-1">
                                       <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                       View ID Card
                                    </a>
                                @else
                                    <span class="text-[10px] text-red-400 italic">No ID Card</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-black text-gray-900">{{ $order->motor->nama }}</div>
                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-mono font-bold border border-gray-200">
                                {{ $order->motor->no_polisi }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-500 uppercase font-bold">Start</div>
                            <div class="text-gray-800 font-medium">{{ $order->tgl_pinjam->format('d M Y') }}</div>
                            
                            <div class="text-xs text-gray-500 uppercase font-bold mt-2">End</div>
                            <div class="text-gray-800 font-medium">{{ $order->tgl_kembali->format('d M Y') }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col items-start justify-center">
                                {{-- 1. Total Harga --}}
                                <div class="text-sm font-black text-gray-900">
                                    Rp {{ number_format($order->total_harga) }}
                                </div>

                                {{-- 2. Jenis Pembayaran --}}
                                <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wide mb-1.5">
                                    {{ $order->jenisBayar->jenis_bayar }}
                                </div>
                                
                                {{-- 3. Tombol Bukti / Status Unpaid (Persis di bawah) --}}
                                @if($order->bukti_bayar)
                                    <a href="{{ filter_var($order->bukti_bayar, FILTER_VALIDATE_URL) ? $order->bukti_bayar : asset('storage/'.$order->bukti_bayar) }}" 
                                    target="_blank" 
                                    class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase rounded border border-blue-200 hover:bg-blue-100 transition-colors w-full justify-center"
                                    title="View Proof">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Proof
                                    </a>
                                @else
                                    <span class="inline-block text-center w-full text-[10px] text-red-500 font-bold bg-red-50 px-2 py-1 rounded border border-red-100 uppercase tracking-wider">
                                        Unpaid
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'disetujui' => 'bg-green-100 text-green-800 border-green-200',
                                    'selesai' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                                    'dibayar' => 'bg-purple-100 text-purple-800 border-purple-200',
                                ];
                                $statusLabel = [
                                    'pending' => 'Pending',
                                    'disetujui' => 'Active',
                                    'selesai' => 'Completed',
                                    'ditolak' => 'Rejected',
                                    'dibayar' => 'Paid'
                                ];
                                $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                                $label = $statusLabel[$order->status] ?? ucfirst($order->status);
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wide border {{ $class }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{-- Logika Status PENDING (Cek Expired 1 Jam) --}}
                            @if($order->status == 'pending')
                                @php
                                    // Hitung selisih jam antara waktu order dibuat dengan waktu sekarang
                                    $orderTime = \Carbon\Carbon::parse($order->created_at);
                                    $isExpired = $orderTime->diffInHours(now()) >= 1;
                                @endphp

                                @if($isExpired)
                                    {{-- Tampilan jika sudah lebih dari 1 jam --}}
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-600">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Expired
                                    </span>
                                @else
                                    {{-- Tampilan jika masih dalam masa tunggu bayar --}}
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700 animate-pulse">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Waiting Payment
                                    </span>
                                @endif

                            {{-- Logika Status DIBAYAR (Muncul Tombol Aksi) --}}
                            @elseif($order->status == 'dibayar')
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Approve --}}
                                    <form id="approve-{{ $order->id }}" action="{{ route('admin.transaksi.verifikasi', $order->id) }}" method="POST" style="display:none;">
                                        @csrf <input type="hidden" name="aksi" value="terima">
                                    </form>
                                    <button onclick="confirmAction('approve-{{ $order->id }}', 'Approve this order?')" 
                                            class="p-2 bg-green-500 text-white rounded hover:bg-green-600 shadow-md transition-transform hover:scale-105" title="Approve">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    
                                    {{-- Tombol Reject --}}
                                    <form id="reject-{{ $order->id }}" action="{{ route('admin.transaksi.verifikasi', $order->id) }}" method="POST" style="display:none;">
                                        @csrf <input type="hidden" name="aksi" value="tolak">
                                    </form>
                                    <button onclick="confirmAction('reject-{{ $order->id }}', 'Reject this order?')"
                                            class="p-2 bg-red-500 text-white rounded hover:bg-red-600 shadow-md transition-transform hover:scale-105" title="Reject">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>

                            {{-- Logika Status DISETUJUI (Tombol Return) --}}
                            @elseif($order->status == 'disetujui')
                                <form id="return-{{ $order->id }}" action="{{ route('admin.transaksi.kembalikan', $order->id) }}" method="POST" style="display:none;">
                                    @csrf
                                </form>
                                <button onclick="confirmAction('return-{{ $order->id }}', 'Confirm bike return?')" 
                                        class="w-full px-3 py-2 bg-black text-victory font-bold uppercase text-[10px] tracking-widest rounded hover:bg-gray-800 transition-all shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Return Bike
                                </button>

                            {{-- Status Lainnya (Selesai/Batal) --}}
                            @else
                                <span class="text-gray-300 font-bold text-xs select-none uppercase tracking-wide">&mdash; Closed &mdash;</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- 3. Update Colspan dari 7 menjadi 8 --}}
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <p>No transactions found matching your search.</p>
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