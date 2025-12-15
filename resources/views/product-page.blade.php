<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etalase Produk - Designplus</title>

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
    </style>
</head>

<body class="bg-white text-gray-800 font-sans antialiased">

    <nav class="fixed top-0 left-0 w-full bg-white shadow-sm z-50 border-b border-gray-100 h-[80px]">
        <div class="h-full px-6 lg:px-10 flex items-center justify-between">

            <a href="{{ route('home') }}" class="text-2xl font-bold text-brand-blue tracking-tighter shrink-0 mr-8">
                Designplus.
            </a>

            <div class="hidden lg:flex flex-grow justify-center max-w-[600px] mx-auto">
                <div
                    class="flex items-center w-full bg-brand-light rounded-xl px-4 py-2.5 transition focus-within:ring-2 focus-within:ring-brand-blue/20">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
                    <input type="text" placeholder="Cari produk"
                        class="w-full bg-transparent border-none outline-none ml-3 text-sm text-gray-700 placeholder-gray-500">
                </div>
            </div>

            <div class="hidden lg:flex items-center gap-8 ml-8">
                <ul class="flex items-center gap-6 text-[15px] font-medium text-gray-600">

                    <li>
                        <a href="{{ route('home') }}"
                            class="{{ request()->routeIs('home') ? 'text-brand-blue font-bold' : 'hover:text-brand-blue transition' }}">
                            Beranda
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('product.index') }}"
                            class="{{ request()->routeIs('product.*') ? 'text-brand-blue font-bold' : 'hover:text-brand-blue transition' }}">
                            Produk
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('layanan') }}"
                            class="{{ request()->routeIs('layanan') ? 'text-brand-blue font-bold' : 'hover:text-brand-blue transition' }}">
                            Layanan
                        </a>
                    </li>
                </ul>

                <div class="h-6 w-px bg-gray-200"></div>

                <div class="flex items-center gap-6">
                    <a href="#" class="text-xl text-gray-700 hover:text-brand-blue transition">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-brand-blue transition group">
                        <i class="fa-regular fa-user text-xl group-hover:text-brand-blue"></i>
                        <span class="font-medium text-[15px]">Tamu</span>
                    </a>
                </div>
            </div>

            <button id="mobile-menu-btn" class="lg:hidden text-2xl text-gray-700 focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <div id="mobile-menu"
            class="hidden lg:hidden bg-white border-t border-gray-100 absolute w-full left-0 top-[80px] shadow-lg p-5 flex flex-col gap-4">
            <div class="flex items-center bg-brand-light rounded-xl px-4 py-3 w-full">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                <input type="text" placeholder="Cari produk"
                    class="w-full bg-transparent border-none outline-none ml-3 text-sm">
            </div>

            <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-brand-blue font-bold' : 'text-gray-700 font-medium hover:text-brand-blue' }}">
                Beranda
            </a>

            <a href="{{ route('product.index') }}"
                class="{{ request()->routeIs('product.*') ? 'text-brand-blue font-bold' : 'text-gray-700 font-medium hover:text-brand-blue' }}">
                Produk
            </a>

            <a href="{{ route('layanan') }}"
                class="{{ request()->routeIs('layanan') ? 'text-brand-blue font-bold' : 'text-gray-700 font-medium hover:text-brand-blue' }}">
                Layanan
            </a>

            <hr class="border-gray-100">
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600">User</span>
                <div class="flex gap-4 text-xl">
                    <i class="fa-regular fa-user"></i>
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="relative h-[400px] flex items-center justify-center text-center text-white mb-10">
            <div class="absolute inset-0 bg-black/50 z-10"></div>
            <div class="absolute inset-0 bg-cover bg-center z-0"
                style="background-image: url('{{ asset('assets/bg_home.png') }}');"></div>

            <div class="relative z-20 px-4 max-w-3xl">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight drop-shadow-md">Produk Kami</h2>
                <p class="text-lg md:text-xl opacity-90 font-light drop-shadow-sm">Temukan produk atau layanan Kami yang
                    sesuai dengan kebutuhan Anda.</p>
            </div>
        </section>

        <div class="w-full px-6 md:px-12 lg:px-16 mx-auto">

            <nav class="flex items-center text-sm text-gray-500 mb-8">
                <a href="#" class="text-brand-blue font-medium hover:underline">Home</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-800 font-medium">Produk</span>
            </nav>

            <div class="mb-10 border-b border-gray-100 pb-4">
                <h2 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Etalase Produk</h2>
                <p class="text-gray-500">Temukan produk unggulan kami dan sesuaikan dengan kebutuhan Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-20">

                @forelse($products as $product)
                    <div onclick="window.location.href='{{ url('/product/' . $product->id) }}'"
                        class="group relative bg-white border border-gray-200 rounded-xl overflow-hidden cursor-pointer hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col h-full">

                        <button onclick="toggleWishlist(this, event)"
                            class="absolute top-3 right-3 z-20 w-9 h-9 rounded-full bg-white/90 backdrop-blur text-gray-400 hover:bg-red-50 flex items-center justify-center shadow-sm transition-all duration-300 group-hover:scale-100">

                            <i class="fa-regular fa-heart text-lg transition-transform duration-200"></i>
                        </button>

                        <div class="h-[220px] overflow-hidden bg-gray-50 border-b border-gray-100">
                            <img src="{{ asset($product->file) }}" alt="{{ $product->nama }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <span
                                class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $product->kategori }}</span>

                            <h3
                                class="text-base font-bold text-gray-900 leading-snug mb-2 group-hover:text-brand-blue transition line-clamp-2">
                                {{ $product->nama }}
                            </h3>

                            <div class="flex items-center gap-1 mb-4">
                                <div class="flex text-yellow-400 text-xs">
                                    @php
                                        $rating = $product->rating;
                                        $full = floor($rating);
                                        $half = ($rating - $full) >= 0.5;
                                    @endphp
                                    @for($i = 0; $i < $full; $i++) <i class="fa-solid fa-star"></i> @endfor
                                    @if($half) <i class="fa-solid fa-star-half-stroke"></i> @php $full++; @endphp @endif
                                    @for($i = $full; $i < 5; $i++) <i class="fa-regular fa-star text-gray-300"></i> @endfor
                                </div>
                                <span class="text-xs text-gray-500 ml-1">({{ $rating }})</span>
                            </div>

                            <div
                                class="mt-auto pt-3 border-t border-dashed border-gray-200 flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Rp
                                    {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-16 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-600">Belum ada produk</h3>
                        <p class="text-gray-400 text-sm">Coba jalankan seeder atau cek koneksi database.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </main>

    <footer class="bg-brand-light pt-16 border-t border-blue-100/50 mt-12">
        <div class="w-full px-6 md:px-12 lg:px-16 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-16 mb-12">

                <div>
                    <div class="text-2xl font-extrabold text-brand-blue mb-4 tracking-tighter">Designplus.</div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 pr-4">
                        Solusi Cetak Profesional dan Terpercaya untuk kebutuhan bisnis Anda. Kualitas terbaik dengan
                        pelayanan tercepat.
                    </p>
                    <div class="flex items-center gap-5">
                        <a href="#"
                            class="flex items-center gap-2 text-sm font-bold text-brand-blue hover:text-brand-dark transition">
                            <i class="fa-brands fa-instagram text-lg"></i> designplus
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 text-sm font-bold text-brand-blue hover:text-brand-dark transition">
                            <i class="fa-brands fa-facebook text-lg"></i> designPlus
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-900 text-lg mb-5 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded bg-brand-blue/10 flex items-center justify-center text-brand-blue text-sm">
                            <i class="fa-solid fa-address-book"></i>
                        </span>
                        Kontak
                    </h3>
                    <ul class="space-y-4 text-sm text-gray-600">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-brand-blue mt-1 shrink-0"></i>
                            <span>Jl. Designplus No.32, Bekasi,<br>Cikarang Selatan, 27381</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-brand-blue shrink-0"></i>
                            <span>+6281329176328</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-brand-blue shrink-0"></i>
                            <span>cs@designplus.com</span>
                        </li>
                    </ul>
                </div>

                <div class="w-full">
                    <h3 class="font-bold text-gray-900 text-lg mb-5">Lokasi Kami</h3>
                    <div class="rounded-xl overflow-hidden shadow-sm border border-gray-200 h-[200px] bg-gray-200">
                        <iframe src="https://maps.google.com/maps?q=Bekasi&output=embed" width="100%" height="100%"
                            style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-brand-dark text-white text-center py-5 text-sm font-medium">
            <div class="container mx-auto">
                © 2025 Designplus. Semua Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>
    <div id="wishlist-toast" class="fixed inset-0 z-[100] flex items-center justify-center hidden pointer-events-none">

        <div id="toast-overlay"
            class="absolute inset-0 bg-black/20 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

        <div id="toast-content"
            class="relative bg-white rounded-2xl shadow-2xl p-6 flex items-center gap-4 transform scale-90 opacity-0 transition-all duration-300 pointer-events-auto min-w-[300px]">

            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check text-xl text-green-600"></i>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 text-lg">Berhasil!</h4>
                <p class="text-sm text-gray-500">Produk ditambahkan ke Wishlist.</p>
            </div>

            <button onclick="closeToast()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        function toggleWishlist(button, event) {
            event.stopPropagation();

            const icon = button.querySelector('i');

            if (icon.classList.contains('fa-regular')) {

                icon.classList.remove('fa-regular', 'text-gray-400');
                icon.classList.add('fa-solid', 'text-red-500');

                icon.style.transform = "scale(1.2)";
                setTimeout(() => icon.style.transform = "scale(1)", 200);

                showToast("Produk ditambahkan ke Wishlist");

            } else {

                icon.classList.remove('fa-solid', 'text-red-500');
                icon.classList.add('fa-regular', 'text-gray-400');

            }
        }

        let toastTimeout;

        function showToast(message) {
            const toast = document.getElementById('wishlist-toast');
            const overlay = document.getElementById('toast-overlay');
            const content = document.getElementById('toast-content');

            clearTimeout(toastTimeout);

            toast.classList.remove('hidden');

            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            toastTimeout = setTimeout(() => {
                closeToast();
            }, 3000);
        }

        function closeToast() {
            const toast = document.getElementById('wishlist-toast');
            const overlay = document.getElementById('toast-overlay');
            const content = document.getElementById('toast-content');

            overlay.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300);
        }
    </script>
</body>

</html>