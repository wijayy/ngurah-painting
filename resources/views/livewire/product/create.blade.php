<div class="">
    <flux:session>{{ $title }} </flux:session>

    <form wire:submit='save' class="bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <flux:input wire:model.live='nama' label="Nama Produk" required></flux:input>
            <flux:input wire:model.live='harga' label="Harga" type="number" required></flux:input>
            <flux:input wire:model.live='persentase_komisi' type="number" min="0" max='100' label="Persentase Komisi" required></flux:input>
            <flux:select wire:model.live='status' requred label="Status">
                <flux:select.option class="option" value='1'>Aktif</flux:select.option>
                <flux:select.option class="option" value='0'>Non Aktif</flux:select.option>
            </flux:select>
        </div>
        <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
    </form>
</div>
