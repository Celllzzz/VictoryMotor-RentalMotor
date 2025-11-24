<x-app-layout>
    @section('header', 'Dashboard Overview')

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate-fade-in-down">
        <div>
            <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tight">
                Hello, <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-600">{{ Auth::user()->nama }}</span>!
            </h1>
            <p class="text-gray-500 font-medium mt-1">Ready for your next ride?</p>
        </div>
        <a href="{{ route('booking.step1') }}" class="px-6 py-3 bg-black text-white font-bold uppercase tracking-wider rounded-lg shadow-lg hover:bg-victory hover:text-black hover:shadow-yellow-400/50 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
            <span>Book Now</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-victory"></div> <div class="flex items-center gap-4 relative z-10">
                <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600 group-hover:bg-victory group-hover:text-black transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Orders</p>
                    <p class="text-3xl font-black text-gray-900">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div> <div class="flex items-center gap-4 relative z-10">
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Active Rentals</p>
                    <p class="text-3xl font-black text-gray-900">{{ $activeBookings }}</p>
                </div>
            </div>
        </div>

        <a href="{{ route('booking.step1') }}" class="bg-victory p-6 rounded-xl shadow-lg flex items-center justify-between hover:bg-yellow-300 transition-colors cursor-pointer group relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            
            <div class="relative z-10">
                <p class="text-black font-black text-xl uppercase leading-none">Find Your<br>Perfect Bike</p>
                <p class="text-black/70 text-sm font-bold mt-2 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                    Start Exploring <span class="text-lg">&rarr;</span>
                </p>
            </div>
            <div class="p-3 bg-white/20 rounded-full text-black group-hover:rotate-12 transition-transform duration-300 relative z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-black"></span> Recent Activity
            </h3>
            <a href="{{ route('booking.history') }}" class="text-xs text-black hover:text-victory uppercase font-black tracking-widest border-b-2 border-transparent hover:border-victory transition-all">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Bike Model</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Total Price</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-yellow-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 block">{{ $order->motor->nama }}</span>
                            <span class="text-xs text-gray-400">{{ $order->motor->no_polisi }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-600">{{ $order->tgl_pinjam->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-black">Rp {{ number_format($order->total_harga) }}</td>
                        <td class="px-6 py-4">
                            @if($order->status == 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs uppercase font-bold tracking-wide">Pending</span>
                            @elseif($order->status == 'disetujui')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs uppercase font-bold tracking-wide">Active</span>
                            @elseif($order->status == 'selesai')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs uppercase font-bold tracking-wide">Completed</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs uppercase font-bold tracking-wide">{{ $order->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p>No booking history yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>