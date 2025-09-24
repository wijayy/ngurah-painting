<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="border-b flex justify-between items-center text-gray-500 border-black py-2 px-4">
            <div class="">
                <div class="capitalize flex">
                    {{ Auth::user()->role }} <flux:icon.dot></flux:icon.dot> {{ $title ?? null }}</div>
                    @if (session()->has('success'))
                        <div class="text-mine-200">{{ session('success') }} </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="text-rose-500">{{ session('error') }} </div>
                    @endif
            </div>
            <div class="flex gap-4">
                <flux:button class="border-gray-500!" icon="magnifying-glass">Cari</flux:button>
                <flux:button icon="shield" variant="outline">Bantuan</flux:button>
            </div>
        </div>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
