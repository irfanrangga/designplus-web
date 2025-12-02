<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Detail Produk</title>
</head>
<body>
    <x-navbar></x-navbar>
    <main class="px-15 mt-5">
        <div class="flex gap-3">
            <h2>Homepage</h2>
            <h2>></h2>
            <h2>Etalase Produk</h2>
            <h2>></h2>
            <h2>Product-Name</h2>
        </div>
        {{-- Product Detail --}}
        <section>
            <div class="flex gap-10 mt-5">
                {{-- Gambar Produk --}}
                <div class="w-1/2">
                    <img src="https://via.placeholder.com/500" alt="Product Image" class="w-full h-auto rounded-lg">
                </div>
                {{-- Deskripsi Produk --}}
                <div class="w-1/2">
                    <h1 class="text-3xl font-bold mb-4">Product Name</h1>
                    <p class="text-gray-700 mb-6">This is a detailed description of the product. It highlights the features, specifications, and benefits of the product to inform potential customers.</p>
                    <span class="text-2xl font-semibold text-blue-600">$99.99</span>
                    <div class="mt-6">
                        <button class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Add to Cart</button>
                    </div>
                </div>
        </section>
    </main>
    
</body>
</html>