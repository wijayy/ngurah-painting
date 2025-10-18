<div>
    <flux:session>{{ $title }}</flux:session>
    <div class="rounded p-4   bg-white dark:bg-neutral-700">
        <div class="lowercase font-semibold">{{ $title }}</div>
        <div class="flex gap-4 mt-4">
            <flux:input wire:model.live='search' placeholder="Cari nama/no_ktp/membership_no"></flux:input>
            <flux:button as href="{{ route('driver.create') }}" icon="plus">Tambah Driver</flux:button>
        </div>
        <div class="overflow-x-auto">
            <div class="grid grid-cols-14 py-2 mt-4 gap-4 min-w-5xl font-semibold items-center">
                <div class="w-10 text-center">ID DRIVER</div>
                <div class="flex col-span-2 gap-1 items-center">
                    MEMBERSHIP NO
                </div>
                <div class="col-span-3 ">NAMA</div>
                <div class="col-span-2 text-center">STATUS KEANGGOTAAN</div>
                <div class="col-span-2 text-center">SALDO KOMISI</div>
                <div class="col-span-2 text-center">VERIFIED AT</div>
                <div class="col-span-2 text-center">AKSI</div>
            </div>
            @foreach ($drivers as $key => $item)
                <div class="grid grid-cols-14 py-2 gap-4 min-w-5xl items-center">
                    <div class="w-10 text-center">{{ $item->driver->id_driver }}</div>
                    <div class="flex col-span-2 gap-1 items-center">
                        {{ $item->driver->membership_no }}
                    </div>
                    <div class="col-span-3 ">{{ $item->name }}</div>
                    <div class="col-span-2 text-center">{{ $item->driver->status }}</div>
                    <div class="col-span-2 text-center">
                        {{ number_format($item->driver->komisi->whereNull('pembayaran')->sum('komisi'), 0, ',', '.') }}
                    </div>
                    <div class="col-span-2 text-center">{{ $item->email_verified_at->format('Y-m-d') }}</div>
                    <div class="col-span-2 text-center flex justify-center">
                        <a href="{{ route('driver.edit', ['slug' => $item->slug]) }}">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
