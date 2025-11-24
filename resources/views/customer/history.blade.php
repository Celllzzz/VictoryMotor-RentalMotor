<x-app-layout>
    @section('header', 'My Booking History')

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-black text-white uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">#ID</th>
                        <th class="px-6 py-4">Bike Info</th>
                        <th class="px-6 py-4">Schedule</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesanans as $order)
                    <tr class="hover:bg-yellow-50 transition-colors group">
                        <td class="px-6 py-4 text-gray-500 font-mono">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 text-lg">{{ $order->motor->nama }}</div>
                            <div class="text-xs font-mono text-gray-500 bg-gray-100 inline-block px-2 py-0.5 rounded">{{ $order->motor->no_polisi }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs text-gray-400 uppercase font-bold">From</span>
                                <span class="text-gray-800 font-medium">{{ $order->tgl_pinjam->format('d M, H:i') }}</span>
                                <span class="text-xs text-gray-400 uppercase font-bold mt-1">To</span>
                                <span class="text-gray-800 font-medium">{{ $order->tgl_kembali->format('d M, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-black font-black text-lg">Rp {{ number_format($order->total_harga) }}</div>
                            <div class="text-xs text-gray-500 font-medium">{{ $order->jenisBayar->jenis_bayar }}</div>
                        </td>
                        <td class="px-6 py-4">
                             <span class="px-3 py-1 rounded-full text-xs uppercase font-bold tracking-wide border
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : '' }}
                                {{ $order->status == 'disetujui' ? 'bg-green-100 text-green-700 border-green-200' : '' }}
                                {{ $order->status == 'selesai' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}
                                {{ $order->status == 'ditolak' ? 'bg-red-100 text-red-700 border-red-200' : '' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                             @if($order->status == 'pending')
                                <button class="text-xs bg-black text-white px-3 py-2 rounded hover:bg-victory hover:text-black font-bold transition-colors shadow-sm">
                                    Upload Payment
                                </button>
                             @else
                                <span class="text-gray-400 font-bold text-xl select-none">&bull;&bull;&bull;</span>
                             @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            You haven't made any bookings yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>