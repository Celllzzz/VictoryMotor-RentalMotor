<x-app-layout>
    @section('header', 'Complete Payment')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold uppercase mb-4">Order Summary</h3>
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset('storage/'.$pesanan->motor->gambar) }}" class="w-24 h-24 object-cover rounded-lg bg-gray-50">
                    <div>
                        <h4 class="font-black text-xl uppercase">{{ $pesanan->motor->nama }}</h4>
                        <p class="text-sm text-gray-500">{{ $pesanan->motor->no_polisi }}</p>
                        <div class="mt-2 flex gap-2 text-xs font-bold uppercase text-gray-400">
                            <span class="bg-gray-100 px-2 py-1 rounded">Pickup: {{ $pesanan->tgl_pinjam->format('d M, H:i') }}</span>
                            <span class="bg-gray-100 px-2 py-1 rounded">Return: {{ $pesanan->tgl_kembali->format('d M, H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                    <span class="text-gray-500 font-bold uppercase text-xs">Total Amount</span>
                    <span class="text-2xl font-black text-victory">Rp {{ number_format($pesanan->total_harga) }}</span>
                </div>
            </div>

            <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-100">
                <h3 class="text-sm font-bold text-yellow-800 uppercase mb-2">Payment Instructions</h3>
                <p class="text-sm text-yellow-700 mb-2">Silakan transfer ke rekening berikut:</p>
                <p class="font-mono font-bold text-lg text-black">BCA 123-456-7890 <span class="text-xs font-normal text-gray-500">(a.n Victory Motor)</span></p>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-black text-white p-6 rounded-xl shadow-lg sticky top-24">
                
                <div class="text-center mb-6">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Time Remaining</p>
                    <div id="countdown" class="text-4xl font-black text-victory font-mono">01:00:00</div>
                </div>

                <hr class="border-gray-800 mb-6">

                <form action="{{ route('booking.process_payment', $pesanan->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Upload Proof</label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/*" required
                            class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-victory file:text-black hover:file:bg-white cursor-pointer bg-gray-900 rounded p-2 border border-gray-800">
                    </div>

                    <button type="submit" id="btnPay" disabled 
                        class="w-full py-4 rounded font-black uppercase tracking-widest transition-all
                        bg-gray-700 text-gray-500 cursor-not-allowed">
                        I Have Paid
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Countdown Logic
        // Set waktu deadline dari controller (passed as variable)
        // Jika controller kirim string, parse dulu. Di sini asumsi PHP kirim timestamp JS (milidetik)
        const deadline = new Date("{{ $deadline->toIso8601String() }}").getTime();

        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
                document.getElementById("countdown").classList.add('text-red-500');
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = 
                (hours < 10 ? "0" + hours : hours) + ":" +
                (minutes < 10 ? "0" + minutes : minutes) + ":" +
                (seconds < 10 ? "0" + seconds : seconds);
        }, 1000);

        // Enable Button Logic
        const fileInput = document.getElementById('bukti_bayar');
        const btnPay = document.getElementById('btnPay');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                btnPay.disabled = false;
                btnPay.classList.remove('bg-gray-700', 'text-gray-500', 'cursor-not-allowed');
                btnPay.classList.add('bg-victory', 'text-black', 'hover:bg-white', 'shadow-lg', 'transform', 'hover:-translate-y-1');
            } else {
                btnPay.disabled = true;
                // Reset style
                btnPay.classList.add('bg-gray-700', 'text-gray-500', 'cursor-not-allowed');
                btnPay.classList.remove('bg-victory', 'text-black', 'hover:bg-white', 'shadow-lg', 'transform', 'hover:-translate-y-1');
            }
        });
    </script>
</x-app-layout>