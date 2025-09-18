<div>
    <flux:session>{{ $title }}</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        <div class="lowercase font-semibold">{{ $title }}</div>

        <div class="grid grid-cols-16 py-2 mt-4 gap-4 min-w-3xl font-semibold items-center">
            <div class="col-span-2 text-center">ID_PEMBAYARAN</div>
            <div class="flex col-span-2 gap-1 items-center">
                KOMISI_ID
            </div>
            <div class="col-span-2 ">AMOUNT</div>
            <div class="col-span-2 text-center">METODE</div>
            <div class="col-span-2 text-center">BANK TUJUAN</div>
            <div class="col-span-2 text-center">WAKTU TRANSFER</div>
            <div class="col-span-2 text-center">STATUS</div>
            <div class="col-span-2 text-center">AKSI</div>
        </div>
        @foreach ($pembayarans as $key => $item)
            <div class="grid grid-cols-16 py-2 gap-4 min-w-3xl items-center">
                <div class="col-span-2 text-center">{{ $item->id_pembayaran }}</div>
                <div class="flex col-span-2 gap-1 items-center">
                    {{ $item->komisi_id }}
                </div>
                <div class="col-span-2 ">{{ $item->amount }}</div>
                <div class="col-span-2 text-center">{{ $item->metode }}</div>
                <div class="col-span-2 text-center">
                    @if ($item->metode = 'transfer')
                        {{ $item->bank_tujuan }}
                    @else
                        -
                    @endif
                </div>
                <div class="col-span-2 text-center">{{ $item->created_at->format('Y-m-d H:i') }}</div>
                <div class="col-span-2 text-center">{{ $item->status }}</div>
                <div class="col-span-2 text-center flex justify-center">
                    <a href="{{ route('pembayaran.edit', ['slug' => $item->id_pembayaran]) }}">Edit</a>
                </div>
            </div>
        @endforeach
        <div class="flex gap-4 mt-4">
            {{-- <flux:input wire:model.live='search' placeholder="Cari nama/no_ktp/membership_no"></flux:input> --}}
            <flux:button as href="{{ route('pembayaran.create') }}" icon="plus">Tambah Pembayaran</flux:button>
        </div>
    </div>
</div>
