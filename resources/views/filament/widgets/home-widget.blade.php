<x-filament::card>
    <div class="flex items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="leading-tight">
                <p class="text-sm text-gray-400">
                    Back to Home
                </p>
            </div>
        </div>

        <x-filament::button
            tag="a"
            href="{{ route('home') }}"
            icon="heroicon-o-arrow-right-on-rectangle"
            color="gray"
            outlined
        >
            Home
        </x-filament::button>

    </div>
</x-filament::card>
