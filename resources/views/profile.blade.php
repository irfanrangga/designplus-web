<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna | Designplus</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
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
            background-color: #f8f9fa;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="text-gray-800 font-sans antialiased">

    <nav class="fixed top-0 left-0 w-full bg-white shadow-sm z-50 border-b border-gray-100 h-[80px]">
        <div class="h-full px-6 lg:px-10 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-brand-blue tracking-tighter shrink-0 mr-8">Designplus.</a>
            <div class="hidden lg:flex flex-grow justify-center max-w-[600px] mx-auto">
                <div class="flex items-center w-full bg-brand-light rounded-xl px-4 py-2.5 transition focus-within:ring-2 focus-within:ring-brand-blue/20">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
                    <input type="text" placeholder="Cari produk" class="w-full bg-transparent border-none outline-none ml-3 text-sm text-gray-700 placeholder-gray-500">
                </div>
            </div>
            <div class="hidden lg:flex items-center gap-8 ml-8">
                <ul class="flex items-center gap-6 text-[15px] font-medium text-gray-600">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand-blue font-bold' : 'hover:text-brand-blue transition' }}">Beranda</a></li>
                    <li><a href="{{ route('product.index') }}" class="{{ request()->routeIs('product.*') ? 'text-brand-blue font-bold' : 'hover:text-brand-blue transition' }}">Produk</a></li>
                    <li><a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan') ? 'text-brand-blue font-bold' : 'hover:text-brand-blue transition' }}">Layanan</a></li>
                </ul>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-xl text-gray-700 hover:text-brand-blue transition"><i class="fa-solid fa-cart-shopping"></i></a>
                    @auth
                    <div class="group relative">
                        <a href="{{ route('profile') }}" class="flex items-center gap-2 text-gray-700 hover:text-brand-blue transition">
                            <i class="fa-regular fa-user text-xl group-hover:text-brand-blue"></i>
                            <span class="font-medium text-[15px]">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-caret-down text-xs ml-1"></i>
                        </a>
                        <div class="absolute right-0 mt-3 w-40 bg-white border border-gray-200 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform scale-95 group-hover:scale-100 p-2">
                            <a href="{{ route('profile') }}" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition"><i class="fa-solid fa-gear"></i> Profile</a>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition justify-start"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 text-gray-700 hover:text-brand-blue transition group">
                        <i class="fa-regular fa-user text-xl group-hover:text-brand-blue"></i>
                        <span class="font-medium text-[15px]">Masuk/Daftar</span>
                    </a>
                    @endauth
                </div>
            </div>
            <button id="mobile-menu-btn" class="lg:hidden text-2xl text-gray-700 focus:outline-none"><i class="fa-solid fa-bars"></i></button>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 absolute w-full left-0 top-[80px] shadow-lg p-5 flex flex-col gap-4">
            <div class="flex items-center bg-brand-light rounded-xl px-4 py-3 w-full">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                <input type="text" placeholder="Cari produk" class="w-full bg-transparent border-none outline-none ml-3 text-sm">
            </div>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand-blue font-bold' : 'text-gray-700 font-medium hover:text-brand-blue' }}">Beranda</a>
            <a href="{{ route('product.index') }}" class="{{ request()->routeIs('product.*') ? 'text-brand-blue font-bold' : 'text-gray-700 font-medium hover:text-brand-blue' }}">Produk</a>
            <a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan') ? 'text-brand-blue font-bold' : 'text-gray-700 font-medium hover:text-brand-blue' }}">Layanan</a>
            <hr class="border-gray-100">
            @auth
            <div class="py-2 flex flex-col">
                <span class="text-gray-600 text-sm">Selamat datang,</span>
                <span class="font-semibold text-lg text-gray-900 mb-2">{{ Auth::user()->name }}</span>
                <a href="{{ route('profile') }}" class="text-sm font-medium text-brand-blue hover:text-brand-dark flex items-center gap-2"><i class="fa-solid fa-gear"></i> Pengaturan Akun</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 flex items-center gap-2"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                </form>
            </div>
            @else
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600 font-medium">Status</span>
                <a href="{{ route('login') }}" class="text-brand-blue font-semibold hover:underline">Masuk / Daftar</a>
            </div>
            @endauth
        </div>
    </nav>
    @php
    $currentPage = request('page', 'user-info');
    $isActive = fn($page) => $currentPage === $page ? 'bg-brand-light text-brand-blue font-semibold' : 'text-gray-600 hover:bg-gray-50';
    @endphp

    <main class="w-full px-6 md:px-12 lg:px-16 mx-auto py-10 md:py-20">

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Menampilkan error validasi umum --}}
        @if($errors->any() && !session('success'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6" role="alert">
            <p class="font-bold">Error!</p>
            <p class="text-sm">Silakan cek kembali input Anda.</p>
        </div>
        @endif

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaturan Akun</h1>
            <p class="text-gray-500">Kelola informasi profil, kata sandi, dan preferensi Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            <div class="lg:col-span-1 bg-white border border-gray-200 rounded-xl p-6 h-fit shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Profile</h3>

                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('profile', ['page' => 'user-info']) }}" class="flex items-center gap-3 p-3 rounded-lg transition {{ $isActive('user-info') }}">
                            <i class="fa-solid fa-user text-lg"></i> User Info
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile', ['page' => 'wishlist']) }}" class="flex items-center gap-3 p-3 rounded-lg transition {{ $isActive('wishlist') }}">
                            <i class="fa-solid fa-heart text-lg"></i> Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile', ['page' => 'pengaturan']) }}" class="flex items-center gap-3 p-3 rounded-lg transition {{ $isActive('pengaturan') }}">
                            <i class="fa-solid fa-gear text-lg"></i> Pengaturan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile', ['page' => 'notifikasi']) }}" class="flex items-center gap-3 p-3 rounded-lg transition {{ $isActive('notifikasi') }}">
                            <i class="fa-solid fa-bell text-lg"></i> Notifications
                        </a>
                    </li>

                    <hr class="my-4 border-gray-100">

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 p-3 rounded-lg transition text-red-600 hover:bg-red-50 w-full justify-start">
                                <i class="fa-solid fa-right-from-bracket text-lg"></i> Log out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-3 bg-white border border-gray-200 rounded-xl p-8 shadow-sm">

                @switch($currentPage)

                {{-- ========================================================== --}}
                {{-- KONTEN 1: USER INFO --}}
                {{-- ========================================================== --}}
                @case('user-info')
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Informasi Akun</h2>

                    <div class="flex items-center gap-6 mb-8">
                        <img src="{{ asset('assets/icon/user.png') }}" alt="{{ Auth::user()->name }}" class="w-20 h-20 rounded-full object-cover border border-gray-100">
                        <div>
                            <span class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                            <p class="text-gray-500 text-sm">{{ Auth::user()->location ?? 'Lokasi Belum Diatur' }}</p>
                        </div>
                    </div>

                    {{-- FORM UPDATE USER INFO --}}
                    <form method="POST" action="{{ route('profile.update-info') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('name') border-red-500 @enderror">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->full_name ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('full_name') border-red-500 @enderror">
                            @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" value="{{ Auth::user()->email }}" disabled class="w-full border-gray-200 bg-gray-50 rounded-lg p-2.5 cursor-not-allowed">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('phone') border-red-500 @enderror">
                            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-1">
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <input type="text" id="location" name="location" value="{{ old('location', Auth::user()->location ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('location') border-red-500 @enderror">
                            @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-1">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('postal_code') border-red-500 @enderror">
                            @error('postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2 mt-4">
                            <button type="submit" class="px-6 py-3 bg-brand-blue text-white font-semibold rounded-lg hover:bg-brand-dark transition shadow">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                @break

                {{-- ========================================================== --}}
                {{-- KONTEN 2: PENGATURAN (Ubah Password) --}}
                {{-- ========================================================== --}}
                @case('pengaturan')
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Ubah Kata Sandi</h2>

                    @if($errors->has('current_password'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm" role="alert">
                        {{ $errors->first('current_password') }}
                    </div>
                    @endif

                    {{-- FORM UPDATE PASSWORD --}}
                    <form method="POST" action="{{ route('profile.update-password') }}" class="max-w-md space-y-4 mb-10">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('current_password') border-red-500 @enderror">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                            <input type="password" id="new_password" name="new_password" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5 @error('new_password') border-red-500 @enderror">
                            @error('new_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue/20 p-2.5">
                        </div>

                        <button type="submit" class="px-6 py-3 bg-brand-blue text-white font-semibold rounded-lg hover:bg-brand-dark transition shadow">
                            Update Kata Sandi
                        </button>
                    </form>

                    {{-- Preferensi Notifikasi dan Zona Bahaya --}}
                    <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-6 border-b border-gray-100 pb-3">Preferensi Notifikasi</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2">
                            <div>
                                <h4 class="font-medium text-gray-800">Promo dan Penawaran</h4>
                                <p class="text-sm text-gray-500">Dapatkan notifikasi diskon dan produk baru.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-blue/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-blue"></div>
                            </label>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <div>
                                <h4 class="font-medium text-gray-800">Update Status Pesanan</h4>
                                <p class="text-sm text-gray-500">Kirim email saat pesanan selesai diproses atau dikirim.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="checkbox" value="" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-blue/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-blue"></div>
                            </label>
                        </div>
                    </div>
                    <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-xl mt-12" role="alert">
                        <h3 class="font-bold text-lg mb-2">Zona Bahaya</h3>
                        <p class="text-sm mb-4">Tindakan ini akan menghapus data Anda secara permanen.</p>
                        <button type="button" class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">Hapus Akun Saya</button>
                    </div>
                </div>
                @break

                {{-- KONTEN 3: WISHLIST --}}
                @case('wishlist')
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Daftar Wishlist</h2>
                    <div class="text-center py-10 border border-dashed border-gray-300 rounded-xl bg-gray-50"><i class="fa-solid fa-heart-crack text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 font-medium">Anda belum menambahkan produk ke Wishlist.</p><a href="{{ route('product.index') }}" class="text-brand-blue hover:underline text-sm mt-2 block">Mulai Jelajahi Produk</a>
                    </div>
                </div>
                @break

                {{-- KONTEN 4: NOTIFIKASI --}}
                @case('notifikasi')
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Notifikasi Terbaru</h2>
                    <div class="text-center py-10 border border-dashed border-gray-300 rounded-xl bg-gray-50"><i class="fa-solid fa-bell-slash text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 font-medium">Tidak ada notifikasi baru untuk saat ini.</p>
                    </div>
                </div>
                @break

                @default
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-3">Informasi Akun</h2>
                    <p class="text-gray-500">Halaman tidak ditemukan. Kembali ke Informasi Akun.</p>
                </div>
                @endswitch

            </div>
        </div>
    </main>

    <footer class="bg-brand-light pt-16 border-t border-blue-100/50 mt-12">
        <div class="w-full px-6 md:px-12 lg:px-16 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-16 mb-12">
                <div>
                    <div class="text-2xl font-extrabold text-brand-blue mb-4 tracking-tighter">Designplus.</div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 pr-4">Solusi Cetak Profesional dan Terpercaya untuk kebutuhan bisnis Anda. Kualitas terbaik dengan pelayanan tercepat.</p>
                    <div class="flex items-center gap-5">
                        <a href="#" class="flex items-center gap-2 text-sm font-bold text-brand-blue hover:text-brand-dark transition"><i class="fa-brands fa-instagram text-lg"></i> designplus</a>
                        <a href="#" class="flex items-center gap-2 text-sm font-bold text-brand-blue hover:text-brand-dark transition"><i class="fa-brands fa-facebook text-lg"></i> designPlus</a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg mb-5 flex items-center gap-2"><span class="w-8 h-8 rounded bg-brand-blue/10 flex items-center justify-center text-brand-blue text-sm"><i class="fa-solid fa-address-book"></i></span> Kontak</h3>
                    <ul class="space-y-4 text-sm text-gray-600">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-brand-blue mt-1 shrink-0"></i><span>Jl. Designplus No.32, Bekasi,<br>Cikarang Selatan, 27381</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-brand-blue shrink-0"></i><span>+6281329176328</span></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-envelope text-brand-blue shrink-0"></i><span>cs@designplus.com</span></li>
                    </ul>
                </div>
                <div class="w-full">
                    <h3 class="font-bold text-gray-900 text-lg mb-5">Lokasi Kami</h3>
                    <div class="rounded-xl overflow-hidden shadow-sm border border-gray-200 h-[200px] bg-gray-200">
                        <iframe src="https://maps.google.com/maps?q=Bekasi&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            menuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');

                const icon = menuBtn.querySelector('i');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                }
            });
        });
    </script>
</body>

</html>
