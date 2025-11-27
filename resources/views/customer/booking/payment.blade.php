<x-app-layout>
    <x-slot name="header">Complete Payment</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in-up">
        
        <div class="md:col-span-2 space-y-6">
            
            <div class="bg-white p-8 rounded-2xl border border-zinc-200 shadow-lg">
                <h3 class="text-lg font-black uppercase text-black mb-6 tracking-wider border-b border-zinc-100 pb-4">
                    Booking Summary
                </h3>
                
                <div class="flex items-start gap-6 mb-6">
                    <img src="{{ asset('storage/'.$pesanan->motor->gambar) }}" 
                         class="w-32 h-24 object-cover rounded-lg bg-zinc-100 ring-1 ring-zinc-200">
                    
                    <div class="space-y-1">
                        <h4 class="font-black text-2xl uppercase text-black">{{ $pesanan->motor->nama }}</h4>
                        <p class="text-sm text-zinc-500 font-bold uppercase tracking-wide">{{ $pesanan->motor->no_polisi }}</p>
                        
                        <div class="mt-3 flex flex-wrap gap-2">
                            <div class="px-3 py-1 bg-zinc-100 rounded text-[10px] font-bold uppercase text-zinc-500 tracking-wider border border-zinc-200">
                                Pickup: <span class="text-black">{{ $pesanan->tgl_pinjam->format('d M, H:i') }}</span>
                            </div>
                            <div class="px-3 py-1 bg-zinc-100 rounded text-[10px] font-bold uppercase text-zinc-500 tracking-wider border border-zinc-200">
                                Return: <span class="text-black">{{ $pesanan->tgl_kembali->format('d M, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-zinc-100 pt-4 flex justify-between items-center bg-zinc-50 -mx-8 -mb-8 p-8 mt-8">
                    <span class="text-zinc-500 font-bold uppercase text-xs tracking-widest">Total Amount</span>
                    <span class="text-3xl font-black text-black">Rp {{ number_format($pesanan->total_harga) }}</span>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-zinc-200 shadow-md relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-victory"></div>

                <h3 class="text-sm font-black text-black uppercase tracking-widest mb-4 flex items-center gap-2">
                    Payment Instructions 
                    <span class="bg-black text-white px-2 py-0.5 rounded text-[10px]">{{ $pesanan->jenisBayar->jenis_bayar }}</span>
                </h3>

                @if($pesanan->jenisBayar->jenis_bayar == 'QRIS')
                    <div class="flex flex-col items-center justify-center text-center space-y-4">
                        <p class="text-sm text-zinc-600">Scan the QR code below to pay:</p>
                        <div class="p-4 bg-white border-2 border-zinc-900 rounded-xl inline-block shadow-lg">
                            <img src="{{ asset('images/qris.png') }}" alt="QRIS Code" class="w-48 h-48 object-contain">
                        </div>
                        <p class="text-xs text-zinc-400 uppercase font-bold tracking-wider">Victory Motor Merchant</p>
                    </div>

                @elseif(Str::contains($pesanan->jenisBayar->jenis_bayar, 'VA') || Str::contains($pesanan->jenisBayar->jenis_bayar, 'Transfer'))
                    <div class="space-y-4">
                        <p class="text-sm text-zinc-600">Please transfer to the following Virtual Account Number:</p>
                        
                        <div class="bg-zinc-50 p-6 rounded-xl border border-zinc-200 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div class="text-center md:text-left">
                                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Bank</p>
                                <p class="text-xl font-black text-black">BCA</p>
                            </div>
                            <div class="text-center md:text-right">
                                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1">Virtual Account No.</p>
                                <p class="text-2xl font-mono font-black text-victory tracking-widest bg-black px-4 py-2 rounded-lg shadow-sm select-all">
                                    8800 1234 5678
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex gap-2 text-xs text-zinc-500 bg-yellow-50 p-3 rounded border border-yellow-100">
                            <svg class="w-4 h-4 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p>Transfer the exact amount down to the last 3 digits.</p>
                        </div>
                    </div>

                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-zinc-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <p class="font-bold text-zinc-800">Pembayaran Tunai di Lokasi</p>
                        <p class="text-sm text-zinc-500 mt-2">Silakan lakukan pembayaran saat pengambilan motor di kantor kami.</p>
                    </div>
                @endif

            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-black p-6 rounded-2xl border border-zinc-800 sticky top-32 text-center text-white shadow-2xl ring-4 ring-zinc-100">
                
                <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-[0.2em] mb-4">Payment Deadline</p>
                
                <div id="countdown" class="text-4xl font-mono font-black text-victory mb-8 tracking-widest">
                    01:00:00
                </div>

                <hr class="border-zinc-800 mb-8">

                <form action="{{ route('booking.process_payment', $pesanan->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    
                    <div class="mb-6 text-left">
                        <label class="block text-[10px] font-bold uppercase text-zinc-400 mb-2 tracking-wider">Upload Payment Proof</label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/*" 
                            class="cursor-pointer w-full text-xs text-zinc-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-md file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-victory file:text-black hover:file:bg-white cursor-pointer bg-zinc-900 rounded-lg border border-zinc-800 focus:outline-none focus:border-victory transition-colors">
                    </div>

                    <button type="submit" id="btnPay" disabled 
                        class="w-full py-4 rounded-lg font-black uppercase tracking-[0.2em] text-xs transition-all duration-300
                        bg-zinc-800 text-zinc-600 cursor-not-allowed border border-zinc-700">
                        I Have Paid
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 1. Countdown Logic 
        const deadline = new Date("{{ $deadline->toIso8601String() }}").getTime();

        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                clearInterval(x);
                const timerEl = document.getElementById("countdown");
                timerEl.innerHTML = "EXPIRED";
                timerEl.classList.remove('text-victory');
                timerEl.classList.add('text-red-500');
                
                // Disable form inputs
                document.getElementById('bukti_bayar').disabled = true;
                document.getElementById('btnPay').disabled = true;
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

        // ---------------------------------------------------------
        // 2. VALIDATION LOGIC 
        // ---------------------------------------------------------
        const paymentForm = document.getElementById('paymentForm');
        const fileInput = document.getElementById('bukti_bayar');
        const btnPay = document.getElementById('btnPay');

        // Fungsi Helper untuk Ganti Style Tombol
        function updateButtonState(isValid) {
            if (isValid) {
                btnPay.disabled = false;
                btnPay.classList.remove('bg-zinc-800', 'text-zinc-600', 'cursor-not-allowed', 'border-zinc-700');
                btnPay.classList.add('bg-victory', 'text-black', 'hover:bg-white', 'shadow-[0_0_20px_rgba(244,224,109,0.4)]', 'transform', 'hover:-translate-y-1', 'border-transparent');
            } else {
                btnPay.disabled = true;
                btnPay.classList.add('bg-zinc-800', 'text-zinc-600', 'cursor-not-allowed', 'border-zinc-700');
                btnPay.classList.remove('bg-victory', 'text-black', 'hover:bg-white', 'shadow-[0_0_20px_rgba(244,224,109,0.4)]', 'transform', 'hover:-translate-y-1', 'border-transparent');
            }
        }

        // A. Cek Ukuran File Saat Dipilih
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB

                // Jika file terlalu besar
                if (file.size > maxSize) {
                    this.value = ''; // Reset input
                    updateButtonState(false); // Matikan tombol

                    // Tampilkan Error Global
                    if(typeof showErrorAlert === 'function') {
                        showErrorAlert('<b>Payment Proof</b> file size exceeds the 2MB limit.');
                    } else {
                        Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Max 2MB' });
                    }
                } else {
                    // Jika valid, nyalakan tombol
                    updateButtonState(true);
                }
            } else {
                // Jika user cancel pilih file
                updateButtonState(false);
            }
        });

        // B. Cek Terakhir Saat Submit (Untuk keamanan)
        paymentForm.addEventListener('submit', function(e) {
            if (fileInput.files.length === 0) {
                e.preventDefault();
                const msg = 'Please upload your <b>Payment Proof</b> first.';
                
                if(typeof showErrorAlert === 'function') {
                    showErrorAlert(msg);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', html: msg });
                }
            }
        });
    </script>
</x-app-layout>