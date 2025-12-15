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

@push('scripts')
    <script>
    // --- 1. Logic Hamburger Menu (Yang Lama) ---
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
        
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#005BEC',
                            dark: '#0A43C3',
                            light: '#EEF2FF',
                            gray: '#f8f9fa' // warna background section
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
@endpush
