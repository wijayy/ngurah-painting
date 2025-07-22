<div>
    <flux:session>Pencairan Komisi Transaksi {{ $transaksi->nomor_transaksi }} ke Driver
        {{ $transaksi->komisi->driver->user->name }}</flux:session>

    <form wire:submit='save' class="rounded p-4 space-y-4 bg-white dark:bg-neutral-700">
        <div class="w-1/2">
            <flux:input type="file" wire:model.live='bukti_pembayaran' :label="'Bukti Pembayaran'"></flux:input>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model.live='komisi' type="number" :label="'Komisi'" required></flux:input>
            <flux:select wire:model.live='metode_pembayaran' :label="'Metode Pembayaran'" required>
                <flux:select.option value="cash">Cash</flux:select.option>
                <flux:select.option value="transfer">Transfer</flux:select.option>
            </flux:select>
        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
