<div>
    <flux:session>Accept The Driver Demands</flux:session>

    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <div class="">{{ $penukaran->driver->name }} Meminta Penukaran {{ $penukaran->poin }} Poin Sebesar Rp.
            {{number_format($penukaran->jumlah, 0, ',', '.')  }}</div>
        <form wire:submit='save' class="mt-4" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <flux:input type="file" wire:model.live='bukti_penukaran' required label="Bukti Penukaran"></flux:input>
            </div>
            {{-- <input type="hidden" name="confirmation_amount" value="{{ $expect }}"> --}}
            <div class="grid grid-cols-2 gap-4">

                <flux:input wire:model.live='jumlah' type="number" label="Jumlah Penukaran" required></flux:input>
                <flux:input wire:model.live='metode_penukaran' type="number" label="Metode Penukaran" readonly>
                </flux:input>
            </div>
            <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
        </form>
    </div>
</div>
