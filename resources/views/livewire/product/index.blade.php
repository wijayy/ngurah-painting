<div>
    <flux:session>Produk</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        <div class="lowercase font-semibold">{{ $title }}</div>
        <div class="flex gap-4 mt-4">
            <flux:input wire:model.live='search' placeholder="Cari produk"></flux:input>
            <flux:button as href="{{ route('product.create') }}" icon="plus">Tambah Produk</flux:button>
        </div>
        <div class="grid grid-cols-12 py-2 gap-4 min-w-3xl font-semibold items-center">
            <div class="w-10 font-semibold uppercase text-center">#</div>
            <div class="flex col-span-3 gap-1 font-semibold uppercase items-center">
                Nama Produk
            </div>
            <div class="col-span-2 font-semibold uppercase text-center">Harga</div>
            <div class="col-span-2 font-semibold uppercase text-center">Persentase Komisi</div>
            <div class="col-span-2 font-semibold uppercase text-center">Aktif</div>
            <div class="col-span-2 font-semibold uppercase text-center">Aksi</div>
        </div>
        @foreach ($product as $key => $item)
            <div class="grid grid-cols-12 py-2 gap-4 min-w-3xl items-center">
                <div class="w-10 text-center">{{ $key + 1 }} </div>
                <div class="flex col-span-3 gap-1 items-center">
                    {{ $item->nama }}
                </div>
                <div class="col-span-2 text-center">IDR {{ number_format($item->harga, 0, ',', '.') }} </div>
                <div class="col-span-2 text-center">{{ $item->persentase_komisi }} %</div>
                <div class="col-span-2 text-center">{{ $item->status ? 'true' : 'false' }}</div>
                <div class="col-span-2 text-center flex gap-2 justify-center">
                    <a href="{{ route('product.edit', ['slug'=>$item->slug]) }}">Edit</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script></script>
