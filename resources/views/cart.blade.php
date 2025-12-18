<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - DesignPlus</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#005BEC',
                            dark: '#0A43C3',
                            light: '#EEF2FF',
                            gray: '#f8f9fa'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            padding-top: 80px;
        }

        html {
            scroll-behavior: smooth;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="bg-brand-gray text-gray-800 font-sans antialiased">

    <x-navbar></x-navbar>

    <main class="min-h-screen py-8">
        <div class="container mx-auto px-4 lg:px-8">

            <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-brand-blue">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                            <span class="text-gray-800 font-medium">Keranjang Belanja</span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative">

                <div class="lg:col-span-2 space-y-4">

                    @if($cartItems->count() > 0)
                        <div
                            class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between border border-gray-100">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="select-all"
                                    class="w-4 h-4 text-brand-blue rounded border-gray-300 focus:ring-brand-blue"
                                    onchange="toggleSelectAll(this)">
                                <span class="font-medium text-gray-700">Pilih Semua ({{ $cartItems->count() }} Item)</span>
                            </div>
                        </div>
                    @endif

                    @forelse($cartItems as $item)
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md cart-item-row"
                            data-id="{{ $item->id }}" data-price="{{ $item->product->harga }}">

                            <div class="flex gap-4 sm:gap-6">
                                <div class="flex flex-col justify-center">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-brand-blue rounded border-gray-300 focus:ring-brand-blue item-checkbox"
                                        {{ $item->selected ?? true ? 'checked' : '' }} onchange="calculateGrandTotal()">
                                </div>

                                <div
                                    class="w-24 h-24 sm:w-32 sm:h-32 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100 border border-gray-200">
                                    <img src="{{ asset($item->product->file) }}" alt="{{ $item->product->nama }}"
                                        class="w-full h-full object-cover object-center">
                                </div>

                                <div class="flex flex-1 flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                                                    {{ $item->product->nama }}
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->product->kategori }}</p>
                                            </div>

                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition"
                                                    title="Hapus Item">
                                                    <i class="fa-regular fa-trash-can text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mt-4">
                                        <div class="text-lg font-bold text-brand-blue">
                                            Rp {{ number_format($item->product->harga, 0, ',', '.') }}
                                        </div>

                                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                            <button type="button" onclick="updateQuantity({{ $item->id }}, -1)"
                                                class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition bg-white">
                                                -
                                            </button>

                                            <input type="number" id="qty-{{ $item->id }}" value="{{ $item->quantity }}"
                                                class="w-10 h-8 text-center text-sm border-none focus:ring-0 text-gray-900 bg-white"
                                                readonly>

                                            <button type="button" onclick="updateQuantity({{ $item->id }}, 1)"
                                                class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition bg-white">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-xl shadow-sm border border-gray-100 text-center">
                            <div
                                class="w-20 h-20 bg-brand-light rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-basket-shopping text-3xl text-brand-blue"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Keranjang Anda Kosong</h3>
                            <p class="text-gray-500 mt-2 mb-6">Sepertinya Anda belum memilih layanan apapun.</p>
                            <a href="/product"
                                class="inline-block bg-brand-blue text-white px-6 py-3 rounded-lg font-semibold hover:bg-brand-dark transition">
                                Jelajahi Layanan
                            </a>
                        </div>
                    @endforelse

                </div>

                @if($cartItems->count() > 0)
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-24">
                            <h2 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Belanja</h2>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Total Harga</span>
                                    <span id="summary-subtotal">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Diskon Projek</span>
                                    <span class="text-green-600">- Rp 0</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Pajak (PPN 11%)</span>
                                    <span id="summary-tax">Rp 0</span>
                                </div>
                            </div>

                            <hr class="border-dashed border-gray-200 my-4">

                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-bold text-gray-900">Total Tagihan</span>
                                <span class="text-xl font-bold text-brand-blue" id="summary-total">Rp 0</span>
                            </div>

                            <a href="/checkout"
                                class="w-full bg-brand-blue hover:bg-brand-dark text-white font-semibold py-3.5 px-4 rounded-lg transition-colors duration-200 shadow-lg shadow-blue-500/30 flex justify-center items-center gap-2">
                                <span>Lanjut ke Pembayaran</span>
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>

                            <div class="mt-4 flex items-center justify-center gap-2 text-gray-400 text-xs">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>Transaksi Aman & Terenkripsi</span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </main>

    <x-footer></x-footer>

    @stack('scripts')
    <script>
        let debounceTimers = {};

        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        function calculateGrandTotal() {
            let subtotal = 0;
            const checkboxes = document.querySelectorAll('.item-checkbox');

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('.cart-item-row');
                    const price = parseFloat(row.getAttribute('data-price'));
                    const qtyInput = row.querySelector('input[type="number"]');
                    const qty = parseInt(qtyInput.value);

                    subtotal += price * qty;
                }
            });

            const tax = subtotal * 0.11;
            const total = subtotal + tax;

            if (document.getElementById('summary-subtotal')) {
                document.getElementById('summary-subtotal').innerText = formatRupiah(subtotal);
                document.getElementById('summary-tax').innerText = formatRupiah(tax);
                document.getElementById('summary-total').innerText = formatRupiah(total);
            }
        }

        function updateQuantity(itemId, change) {
            const input = document.getElementById(`qty-${itemId}`);
            let currentQty = parseInt(input.value);
            let newQty = currentQty + change;

            if (newQty < 1) return;

            input.value = newQty;
            calculateGrandTotal();

            if (debounceTimers[itemId]) {
                clearTimeout(debounceTimers[itemId]);
            }

            debounceTimers[itemId] = setTimeout(() => {

                fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        quantity: newQty,
                        _method: 'PATCH'
                    })
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (!data.success) {
                            input.value = currentQty;
                            calculateGrandTotal();
                            alert('Gagal mengupdate keranjang');
                        } else {
                            console.log('Update sukses');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        input.value = currentQty;
                        calculateGrandTotal();
                    });

            }, 500);
        }

        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = source.checked;
            });
            calculateGrandTotal();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const selectAllBox = document.getElementById('select-all');
            if (selectAllBox) {
                selectAllBox.checked = true;
                toggleSelectAll(selectAllBox);
            } else {
                calculateGrandTotal();
            }
        });
    </script>
</body>

</html>