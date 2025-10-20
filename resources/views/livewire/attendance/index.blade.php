<div>
    <flux:session>{{ $title }}</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        <div class="lowercase font-semibold">{{ $title }}</div>
        <div class="flex gap-4 mt-4">
            <div class="">
                <flux:input type="date" wire:model.live='date'></flux:input>
            </div>
        </div>
        <div class="grid grid-cols-12 py-2 gap-4 min-w-3xl font-semibold items-center">
            <div class="w-10 font-semibold uppercase text-center">ID_STIKER</div>
            <div class="flex col-span-3 gap-1 font-semibold uppercase items-center">
                DRIVER
            </div>
            <div class="col-span-2 font-semibold uppercase text-center">JUMLAH WISATAWAN</div>
            <div class="col-span-2 font-semibold uppercase text-center">NOMOR STIKER</div>
            <div class="col-span-2 font-semibold uppercase text-center">TANGGAL WAKTU</div>
            <div class="col-span-2 font-semibold uppercase text-center">WISATAWAN</div>
        </div>
        @foreach ($kunjungan as $key => $item)
            <div class="grid grid-cols-12 py-2 gap-4 min-w-3xl items-center border-b-2 border-black dark:border-white">
                <div class="w-10 text-center">{{ $item->id_stiker }} </div>
                <div class="flex col-span-3 gap-1 items-center">
                    {{ $item->driver->user->name }}
                </div>
                <div class="col-span-2 text-center">{{ $item->jumlah_wisatawan }}</div>
                <div class="col-span-2 text-center">{{ $item->nomor_stiker }}</div>
                <div class="col-span-2 text-center">{{ $item->tanggal_waktu->format('Y-M-d H:i') }}</div>
                <div class="col-span-2 flex flex-col items-center text-center justify-center gap-2">
                    <div class="">{{ $item->nama }}</div>
                    <div class="">{{ $item->wa }}</div>
                </div>

            </div>
        @endforeach
    </div>
</div>

<script></script>
