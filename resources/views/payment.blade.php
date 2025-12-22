<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembayaran</title>
    
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
                        'card-shadow': 'rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        .custom-radio:checked {
            background-color: #6b78ea;
            border-color: #6b78ea;
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
        }
    </style>
</head>
<body class="bg-brand-bg text-[#333] antialiased">
    <header class="bg-white p-5 sticky top-0 z-50 shadow-sm md:mb-6">
        <div class="text-xl font-bold text-brand-blue">Designplus.</div>
    </header>
    <div class="mx-auto min-h-screen lg:w-2/3">
        
        <main class="p-5 space-y-5 md:p-0">

            <section class="bg-white rounded-xl p-6 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-xl font-semibold text-brand-blue flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Detail Pesanan
                    </h2>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center text-[15px]">
                        <span class="text-gray-600 w-[130px] flex-shrink-0">Nama Produk</span>
                        <div class="flex-grow flex justify-between items-center">
                            <div class="flex items-center gap-2 bg-brand-bg border border-brand-light-blue px-2 py-1 rounded text-brand-light-blue font-medium">
                                <div class="w-7 h-7 bg-[#F5F6FF] rounded flex items-center justify-center overflow-hidden">
                                    <img src="{{ $orderData['product']['image'] }}" alt="Produk" class="w-full h-full object-cover">
                                </div>
                                <span>{{ $orderData['product']['name'] }}</span>
                            </div>
                            <span class="font-semibold text-gray-800">Rp{{ number_format($orderData['product']['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center text-[15px]">
                        <span class="text-gray-600 w-[130px] flex-shrink-0">Pilihan Bahan</span>
                        <div class="flex-grow flex justify-between items-center">
                            <span class="bg-brand-bg border border-brand-light-blue px-2 py-1 rounded text-brand-light-blue font-medium">
                                {{ $orderData['material']['name'] }}
                            </span>
                            <span class="font-semibold text-gray-800">Rp{{ number_format($orderData['material']['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center text-[15px]">
                        <span class="text-gray-600 w-[130px] flex-shrink-0">Pilihan Warna</span>
                        <div class="flex-grow flex justify-between items-center">
                            <div class="flex items-center gap-2 bg-brand-bg border border-brand-light-blue px-2 py-1 rounded text-brand-light-blue font-medium">
                                <div class="w-5 h-5 rounded-full border border-brand-light-blue" style="background-color: {{ $orderData['color']['hex'] }};"></div>
                                <span>{{ $orderData['color']['name'] }}</span>
                            </div>
                            <span class="font-semibold text-gray-800">Rp{{ number_format($orderData['color']['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                     <div class="flex items-center text-[15px]">
                        <span class="text-gray-600 w-[130px] flex-shrink-0">Pilihan Desain</span>
                        <div class="flex-grow flex justify-between items-center">
                            <span class="bg-brand-bg border border-brand-light-blue px-2 py-1 rounded text-brand-light-blue font-medium">
                                {{ $orderData['design']['name'] }}
                            </span>
                            <span class="font-semibold text-gray-800">Rp{{ number_format($orderData['design']['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100">
                    <div class="space-y-2 text-sm text-[#aeacac]">
                        <div class="flex justify-between">
                            <span>Jumlah Pesanan</span>
                            <span class="font-medium text-gray-800">{{ $orderData['quantity'] }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span class="font-medium text-gray-800">Rp{{ number_format($orderData['shipping_cost'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-brand-green">
                            <span>Diskon</span>
                            <span id="discount-display" class="font-medium">- Rp{{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>PPN {{ $orderData['ppn_percentage']*100 }}%</span>
                            <span class="font-medium text-gray-800">Rp{{ number_format($ppn, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-800">Subtotal</span>
                    <span id="grand-total-display" class="text-2xl font-bold text-gray-900">Rp{{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </section>

            <section class="bg-white rounded-xl p-6 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-xl font-semibold text-brand-blue flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Alamat Pengiriman
                    </h2>
                </div>
                
                <div class="relative">
                    <select class="w-full appearance-none bg-white border border-[#e6e8ff] text-gray-700 py-3 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-brand-blue cursor-pointer shadow-sm">
                        @foreach($addresses as $address)
                            <option>{{ $address }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-blue">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </section>

            <form action="{{ route('invoice.process') }}" method="POST">
                @csrf
                <input type="hidden" name="grand_total" value="{{ $grandTotal }}">

                <input type="hidden" name="order_json" value="{{ json_encode($orderData) }}">

                <section class="bg-white rounded-xl p-6 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-xl font-semibold text-brand-blue flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Metode Pembayaran
                    </h2>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center justify-between p-4 border border-[#e0e0e0] rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/icon_bca.png') }}" alt="BCA" class="h-6 w-auto object-contain">
                            <span class="font-medium text-gray-700">BCA M-Banking</span>
                        </div>
                        <input type="radio" name="payment_method" value="bca" class="custom-radio w-5 h-5 text-brand-light-blue border-gray-300 focus:ring-brand-light-blue" checked>
                    </label>

                    <label class="flex items-center justify-between p-4 border border-[#e0e0e0] rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/icon_mandiri.png') }}" alt="Mandiri" class="h-6 w-auto object-contain">
                            <span class="font-medium text-gray-700">Mandiri M-Banking</span>
                        </div>
                        <input type="radio" name="payment_method" value="mandiri" class="custom-radio w-5 h-5 text-brand-light-blue border-gray-300 focus:ring-brand-light-blue">
                    </label>

                    <label class="flex items-center justify-between p-4 border border-[#e0e0e0] rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/icon_gopay.png') }}" alt="Gopay" class="h-6 w-auto object-contain">
                            <span class="font-medium text-gray-700">Gopay</span>
                        </div>
                        <input type="radio" name="payment_method" value="gopay" class="custom-radio w-5 h-5 text-brand-light-blue border-gray-300 focus:ring-brand-light-blue">
                    </label>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-brand-light-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <select id="coupon-select" onchange="updatePrice()" class="block w-full pl-12 pr-10 py-4 text-base border-2 border-brand-light-blue focus:outline-none focus:ring-brand-light-blue focus:border-brand-light-blue sm:text-sm rounded-lg bg-brand-bg text-[#aeacac] font-medium appearance-none cursor-pointer">
                            <option value="0">Pilih kupon untuk mendapat potongan</option>
                            @foreach($coupons as $coupon)
                                <option value="{{ $coupon['value'] }}" data-code="{{ $coupon['code'] }}">{{ $coupon['label'] }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-light-blue">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </div>

                <p class="text-center text-[15px] text-[#888] mt-6 mb-6">
                    Dengan mengonfirmasi pembayaran, Anda telah menyetujui
                    <a href="#" class="underline font-medium hover:text-brand-blue">Syarat & Ketentuan</a> yang berlaku.
                </p>

                <div class="space-y-4">
                    <button class="w-full bg-brand-green hover:bg-[#2a7a5e] text-white font-semibold py-4 rounded-lg shadow-sm transition duration-200 text-base">
                        Konfirmasi Pembayaran
                    </button>
                    <button type="button" onclick="openModal()" class="w-full bg-white border-2 border-brand-red text-brand-red hover:bg-red-50 font-semibold py-4 rounded-lg shadow-sm transition duration-200 text-base">
                        Batal
                    </button>
                </div>

            </section>
            </form>
        </main>
    </div>
    <footer class="text-center text-sm text-white bg-blue-800 py-6 mt-6 ">
            © 2025 Designplus. Semua Hak Cipta Dilindungi.
    </footer>

    <div id="cancel-modal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6">
                
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-brand-red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Batalkan Pembayaran?</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin membatalkan pesanan ini? Semua data yang sudah diisi akan hilang dan Anda akan kembali ke beranda.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button" onclick="confirmCancel()" class="inline-flex w-full justify-center rounded-md bg-brand-red px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:w-auto transition">
                        Ya, Batalkan
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                        Tidak, Kembali
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const itemSubtotal = {{ $itemSubtotal }};
        const shippingCost = {{ $orderData['shipping_cost'] }};
        const ppn = {{ $ppn }};

        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        function updatePrice() {
            const selectElement = document.getElementById('coupon-select');
            const discountValue = parseFloat(selectElement.value) || 0;

            const newGrandTotal = itemSubtotal + shippingCost - discountValue + ppn;

            document.getElementById('discount-display').innerText = '- ' + formatter.format(discountValue);
            document.getElementById('grand-total-display').innerText = formatter.format(newGrandTotal);
        }

        updatePrice();

        function openModal() {
            document.getElementById('cancel-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('cancel-modal').classList.add('hidden');
        }

        function confirmCancel() {
            window.location.href = '/'; 
        }
    </script>
</body>
</html>