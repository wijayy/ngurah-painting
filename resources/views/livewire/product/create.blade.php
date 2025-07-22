<div class="">
    <flux:session>{{ $title }} </flux:session>

    <form wire:submit='save' class="bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <flux:input wire:model.live='name' label="Nama Produk" required></flux:input>
            <flux:input wire:model.live='price' label="Harga" required></flux:input>
        </div>
        <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
    </form>
</div>
