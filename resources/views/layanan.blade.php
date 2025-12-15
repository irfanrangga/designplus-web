<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Designplus</title>

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

    <!-- ================= NAVBAR ================= -->
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
    <!-- =============== END NAVBAR ================= -->


    <!-- ================= MAIN CONTENT ================= -->
    <main class="w-full px-6 md:px-12 lg:px-16 py-20">
        <h1 class="text-4xl font-bold text-gray-800">LAYANAN</h1>
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
</body>

</html>
