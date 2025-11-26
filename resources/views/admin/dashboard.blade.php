<x-admin-layout>
    @section('header', 'Overview')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="p-4 bg-gray-100 rounded-full text-gray-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Fleet</p>
                <p class="text-2xl font-black text-gray-900">{{ $totalMotor }} <span class="text-xs font-medium text-gray-400">Units</span></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="p-4 bg-blue-50 rounded-full text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Rented Out</p>
                <p class="text-2xl font-black text-gray-900">{{ $motorDisewa }} <span class="text-xs font-medium text-gray-400">Active</span></p>
            </div>
        </div>

        <a href="{{ route('admin.transaksi.index') }}" class="bg-green-500 p-6 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:bg-green-400 transition-all cursor-pointer group">
            {{-- Icon Container --}}
            <div class="p-4 bg-white/20 rounded-full text-white group-hover:bg-white group-hover:text-green-600 group-hover:scale-110 transition-transform">
                {{-- Icon: Clipboard Check (Menggambarkan proses verifikasi dokumen/data) --}}
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>

            {{-- Text Content --}}
            <div>
                <p class="text-xs font-bold text-white/80 uppercase tracking-widest mb-1">Verification Needed</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-black text-white">{{ $pesananDibayar }}</p>
                    <span class="text-sm font-bold text-white">Paid Orders</span>
                </div>
            </div>
        </a>

        <div class="bg-black p-6 rounded-xl shadow-md flex items-center gap-4 text-white">
            <div class="p-4 bg-white/10 rounded-full text-victory">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Revenue</p>
                <p class="text-xl font-black text-victory">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800 uppercase tracking-wide text-sm">Recent Transactions</h3>
            <a href="{{ route('admin.transaksi.index') }}" class="text-xs font-bold text-victory hover:text-black uppercase tracking-wider">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Bike</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-yellow-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $order->pemesan->nama }}</td>
                        <td class="px-6 py-4">{{ $order->motor->nama }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->tgl_pinjam->format('d M, H:i') }}</td>
                        <td class="px-6 py-4">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold uppercase">Pending</span>
                            
                            @elseif($order->status == 'dibayar')
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded font-bold uppercase">Paid</span>
                            
                            @elseif($order->status == 'disetujui')
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold uppercase">Active</span>
                            
                            @elseif($order->status == 'selesai')
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-bold uppercase">Completed</span>
                            
                            @elseif($order->status == 'ditolak')
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-bold uppercase">Rejected</span>
                            
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded font-bold uppercase">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.transaksi.index') }}" class="text-gray-400 hover:text-black font-bold text-lg">&rarr;</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">No recent transactions.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>