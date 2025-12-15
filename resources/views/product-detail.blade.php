<!DOCTYPE html>
<html lang="id">
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
    <main class="px-32 mt-24">
        <div class="flex gap-3">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-blue-500">Homepage</a>
            <h2 class="text-slate-400">/</h2>
            <a href="{{ route('product.index') }}" class="text-slate-400 hover:text-blue-500">Etalase Produk</a>
            <h2 class="text-slate-400">/</h2>
            <h2></h2>
        </div>
        {{-- Product Detail --}}
        <section>
            <div class="flex gap-10 mt-5">
                {{-- Gambar Produk --}}
                <div class="w-1/3">
                    <img  class="w-fit rounded-xl" src="{{ asset('assets/baju.png') }}" alt="Casual shirt displayed flat on a plain light background, single garment centered for product display; no visible text; neutral, utilitarian styling intended to inform buyers">
                </div>
                {{-- Deskripsi Produk --}}
                <div class="w-2/3">
                    <h1 class="text-3xl font-bold mb-4">Product Name</h1>
                    <p class="text-gray-700 mb-6">This is a detailed description of the product. It highlights the features, specifications, and benefits of the product to inform potential customers.</p>
                    
                    <p class="text-2xl font-semibold text-blue-600">$99.99</p>
                    <div class="mt-6">
                        <button class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Add to Cart</button>
                    </div>
                </div>
        </section>
    </main>
    <x-footer></x-footer>
    @stack('scripts')
</body>
</html>
