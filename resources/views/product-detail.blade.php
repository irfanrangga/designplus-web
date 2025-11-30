<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etalase Produk - Designplus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        /* Custom kecil untuk menimpa Bootstrap jika perlu */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset("assets/bg_home.png") }}');
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
        .card-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <span class="text-primary">Design</span>plus.
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-3 align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center mt-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Produk Kami</h1>
            <p class="lead">Temukan produk atau layanan Kami yang sesuai dengan kebutuhan Anda.</p>
        </div>
    </section>

    <div class="container my-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
    </div>

    <section class="container mb-5">
        <h2 class="fw-bold mb-4">Etalase Produk</h2>
        
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($products as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm card-product">
                    <div class="position-absolute top-0 end-0 p-3">
                        <button class="btn btn-light rounded-circle btn-sm text-danger shadow-sm">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>

                    <img src="{{ asset($item->file) }}" class="card-img-top product-img" alt="{{ $item->nama }}">
                    
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted">{{ $item->kategori }}</small>
                        <h5 class="card-title fs-6 fw-bold text-dark">{{ $item->nama }}</h5>
                        
                        <div class="mb-2 text-warning small">
                            @for($i = 0; $i < floor($item->rating); $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            @if($item->rating - floor($item->rating) > 0)
                                <i class="fa-solid fa-star-half-stroke"></i>
                            @endif
                            <span class="text-muted ms-1">({{ $item->rating }})</span>
                        </div>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                            <a href="{{ url('/product/'.$item->id) }}" class="text-primary">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center">
                    <p>Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <footer class="bg-light pt-5 mt-5">
        <div class="container pb-4">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-primary">Designplus.</h5>
                    <p class="text-muted">Solusi Cetak Profesional.</p>
                </div>
                </div>
        </div>
        <div class="bg-primary text-white text-center py-3">
            &copy; 2025 Designplus. Semua Hak Cipta Dilindungi.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>