<nav class="flex items-center justify-between mt-2 py-5 px-15 sticky top-0 z-50 shadow-sm bg-white">
    <h2 class="font-bold text-2xl text-blue-500">Designplus</h2>
    <ul class="flex gap-4">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
        <li><x-nav-link href="/" :active="request()->is('/')">About Us</x-nav-link></li>
        <li><x-nav-link href="/test" :active="request()->is('test')">Contact</x-nav-link></li>
        <li><x-nav-link href="/product-detail" :active="request()->is('product-detail')">Our Product</x-nav-link></li>
    </ul>
</nav>