<x-app-layout>
    <x-slot name="header">
        My Booking History
    </x-slot>

    <div class="bg-white border border-zinc-200 rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-600">
                <thead class="bg-black text-white uppercase text-[10px] font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-6 py-5">#ID</th>
                        <th class="px-6 py-5">Bike Info</th>
                        <th class="px-6 py-5">Schedule</th>
                        <th class="px-6 py-5">Total Price</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Proof</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($pesanans as $order)
                    <tr class="hover:bg-zinc-50 transition-all duration-300 group">
                        <td class="px-6 py-5 font-mono text-zinc-400 font-bold text-xs">#{{ $order->id }}</td>
                        <td class="px-6 py-5">
                            <div class="font-black text-zinc-900 text-base uppercase group-hover:text-victory transition-colors">{{ $order->motor->nama }}</div>
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
                             <span class="px-3 py-1.5 rounded-sm text-[10px] uppercase font-black tracking-widest border shadow-sm
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : '' }}
                                {{ $order->status == 'disetujui' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}
                                {{ $order->status == 'selesai' ? 'bg-green-100 text-green-700 border-green-200' : '' }}
                                {{ $order->status == 'ditolak' ? 'bg-red-100 text-red-700 border-red-200' : '' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                             @if($order->status == 'pending')
                                <button class="text-[10px] bg-black text-white px-4 py-2 rounded-sm hover:bg-victory hover:text-black font-black uppercase tracking-widest transition-all hover:-translate-y-0.5 shadow-md">
                                    Upload
                                </button>
                             @elseif($order->bukti_bayar)
                                <div class="flex items-center justify-center gap-1 text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100 w-fit mx-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-wider">Paid</span>
                                </div>
                             @else
                                <span class="text-zinc-300 font-bold">-</span>
                             @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center opacity-50">
                                <svg class="w-12 h-12 text-zinc-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <p class="uppercase tracking-widest text-xs font-bold text-zinc-400">No booking history yet.</p>
                                <a href="{{ url('/#booking-section') }}" class="text-victory hover:underline text-xs mt-2 font-bold hover:text-black transition-colors">Start your first journey</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>