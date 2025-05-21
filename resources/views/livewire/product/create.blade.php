<div class="">
    <flux:session>{{ $title }} </flux:session>

    <form wire:submit.prevent='save' class="bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 md:grid-cols-3">
            <flux:input.file wire:model='image' :preview="$existingImage" label="Product Picture"></flux:input.file>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <flux:input wire:model='name' label="Product Name" required></flux:input>
            <flux:input wire:model='stock' label="Product Stock" required></flux:input>
            <flux:input wire:model='price' label="Product Price" required></flux:input>
        </div>
        <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
    </form>
</div>
