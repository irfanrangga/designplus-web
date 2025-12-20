<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <title>Detail Produk</title>
</head>
<body>
    <x-navbar></x-navbar>

    <main class="w-full px-6 md:px-12 lg:px-16 mx-auto mt-24">
        <div class="hidden gap-3 lg:flex">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-blue-500">Homepage</a>
            <h2 class="text-slate-400">/</h2>
            <a href="{{ route('product.index') }}" class="text-slate-400 hover:text-blue-500">Etalase Produk</a>
            <h2 class="text-slate-400">/</h2>
            <h2 class="text-gray-700">{{ $product->nama }}</h2>
        </div>
        {{-- Product Detail --}}
        <section>
            <div class="flex flex-col lg:flex-row gap-10 mt-5">
                {{-- Gambar Produk --}}
                <div class="w-full lg:w-1/3">
                    <img class="w-full h-96 md:h-[32rem] rounded-xl object-cover border border-gray-200" src="{{ asset($product->file) }}" alt="{{ $product->nama }}">
                </div>
                {{-- Deskripsi Produk --}}
                <div class="w-full lg:w-2/3">
                    <span class="border border-blue-500 bg-blue-100 text-sm text-blue-500 p-2 rounded-lg"><strong class="text-blue-500">{{ $product->kategori }}</strong></span>
                    <h1 class="text-3xl font-bold mb-2 mt-4">{{ $product->nama }}</h1>
                    <div class="flex items-center gap-4 mb-4">
                        <div>Stok {{ $product->stok ?? '0' }}</div>
                        <div>Terjual {{ $product->sold ?? '0' }}</div>
                        <div class="flex items-center text-yellow-400 text-sm">
                            @php
                                $rating = $product->rating ?? 0;
                                $full = floor($rating);
                                $half = ($rating - $full) >= 0.5;
                            @endphp
                            @for($i = 0; $i < $full; $i++) <i class="fa-solid fa-star"></i> @endfor
                            @if($half) <i class="fa-solid fa-star-half-stroke"></i> @php $full++; @endphp @endif
                            @for($i = $full; $i < 5; $i++) <i class="fa-regular fa-star text-gray-300"></i> @endfor
                            <span class="text-sm text-gray-500 ml-2">({{ $rating }})</span>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">Deskripsi produk belum tersedia.</p>
                    <p class="text-2xl font-semibold text-blue-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                    <div class="mt-6">
                        <button class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 w-full lg:w-48">Tambah Keranjang</button>
                    </div>
                </div>
        </section>
    </main>

    <x-footer></x-footer>
    @stack('scripts')
</body>
</html>