<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran - Designplus</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        'brand-bg': '#e9ebfc',
                        'brand-blue': '#2236e0',
                        'brand-light-blue': '#6b78ea',
                        'brand-green': '#328e6e',
                        'brand-red': '#dc2525',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg text-[#333] antialiased">

    <header class="bg-white p-5 sticky top-0 z-50 shadow-sm md:mb-6">
        <div class="text-xl font-bold text-brand-blue text-center md:text-left md:w-2/3 md:mx-auto">Designplus.</div>
    </header>

    <div class="mx-auto min-h-screen lg:w-2/3 p-5 md:p-0 mb-20">
        
        <div class="bg-brand-blue text-white rounded-xl p-4 mb-6 flex justify-between items-center shadow-lg">
            <div>
                <p class="text-sm opacity-90">Batas Akhir Pembayaran</p>
                <p class="font-bold text-lg">{{ $expiryTime->format('d M Y, H:i') }} WIB</p>
            </div>
            <div class="text-right">
                <p class="text-xs bg-white/20 px-2 py-1 rounded inline-block">Menunggu Pembayaran</p>
            </div>
        </div>

        <main class="space-y-6">

            <section class="bg-white rounded-xl p-6 shadow-[0_4px_12px_rgba(0,0,0,0.05)] text-center">
                <p class="text-gray-500 mb-2">Total Pembayaran</p>
                <h1 class="text-3xl font-bold text-brand-blue mb-6">Rp{{ number_format($grandTotal, 0, ',', '.') }}</h1>

                <div class="border-t border-b border-gray-100 py-6">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <img src="{{ asset($paymentData['icon']) }}" alt="Metode Bayar" class="h-8 object-contain">
                        <span class="font-semibold text-gray-700">{{ $paymentData['title'] }}</span>
                    </div>

                    @if($paymentData['is_qris'])
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-white p-3 border border-gray-200 rounded-lg shadow-sm mb-3">
                                <img src="{{ $paymentData['qr_image'] }}" alt="QRIS Code" class="w-48 h-48">
                            </div>
                            <p class="text-sm text-gray-500">Scan QR di atas dengan aplikasi pembayaran Anda</p>
                        </div>
                    @else
                        <div class="bg-brand-bg/50 p-4 rounded-lg inline-block w-full max-w-md">
                            <p class="text-sm text-gray-500 mb-1">Nomor Virtual Account</p>
                            <div class="flex items-center justify-between gap-4">
                                <span id="va-number" class="text-xl font-bold text-gray-800 tracking-wide">{{ $paymentData['account_number'] }}</span>
                                <button onclick="copyToClipboard()" class="text-brand-light-blue font-semibold text-sm hover:text-brand-blue transition">
                                    Salin
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-6 border-t border-gray-100 pt-4">
                    <button onclick="toggleDetails()" id="btn-toggle" class="flex items-center justify-center w-full text-brand-light-blue font-medium text-sm hover:text-brand-blue transition gap-2">
                        <span>Lihat Detail Pesanan</span>
                        <svg id="icon-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>

                <div id="order-details" class="hidden mt-4 bg-brand-bg/30 rounded-lg p-4 text-left text-sm space-y-3 border border-gray-100 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <span class="text-gray-500">Produk</span>
                        <div class="text-right">
                            <span class="block font-semibold text-gray-800">{{ $orderData['product']['name'] }}</span>
                            <span class="text-xs text-gray-500">{{ $orderData['quantity'] }} pcs</span>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Bahan</span>
                        <span class="font-medium text-gray-700">{{ $orderData['material']['name'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Warna</span>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full border border-gray-200" style="background-color: {{ $orderData['color']['hex'] }};"></div>
                            <span class="font-medium text-gray-700">{{ $orderData['color']['name'] }}</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 border-dashed my-2 pt-2">
                        <div class="flex justify-between text-gray-500">
                            <span>Ongkir</span>
                            <span>Rp{{ number_format($orderData['shipping_cost'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>PPN {{ $orderData['ppn_percentage']*100 }}%</span>
                            <span>Termasuk</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl p-6 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-light-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Cara Pembayaran
                </h2>
                
                <div class="space-y-4">
                    @foreach($paymentData['steps'] as $index => $step)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-bg text-brand-light-blue flex items-center justify-center text-xs font-bold mt-0.5">
                            {{ $index + 1 }}
                        </div>
                        <p class="text-gray-600 text-[15px] leading-relaxed">{{ $step }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            <div class="space-y-3 pt-4">
                <button class="w-full bg-brand-blue hover:bg-blue-800 text-white font-semibold py-4 rounded-lg shadow-sm transition duration-200">
                    Cek Status Pembayaran
                </button>
                <a href="/" class="block w-full text-center bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 font-semibold py-4 rounded-lg transition duration-200">
                    Kembali ke Beranda
                </a>
            </div>

        </main>
    </div>

    <script>
        function copyToClipboard() {
            const vaNumber = document.getElementById('va-number').innerText;
            navigator.clipboard.writeText(vaNumber).then(() => {
                alert('Nomor Virtual Account berhasil disalin!');
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
            });
        }

        function toggleDetails() {
            const details = document.getElementById('order-details');
            const btnText = document.querySelector('#btn-toggle span');
            const icon = document.getElementById('icon-arrow');

            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
                btnText.innerText = "Tutup Detail Pesanan";
                icon.classList.add('rotate-180');
            } else {
                details.classList.add('hidden');
                btnText.innerText = "Lihat Detail Pesanan";
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</body>
</html>