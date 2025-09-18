<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="border-b flex justify-between text-gray-500 border-black py-2 px-4">
            <div class="flex capitalize">
                {{ Auth::user()->role }} <flux:icon.dot></flux:icon.dot> {{ $title ?? null }}</div>
            <div class="flex gap-4">
                <flux:button class="border-gray-500!" icon="magnifying-glass">Cari</flux:button>
                <flux:button icon="shield" variant="outline">Bantuan</flux:button>
            </div>
        </div>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
