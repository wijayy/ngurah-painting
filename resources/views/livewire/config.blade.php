<div>
    <flux:session>Bussiness Configuration</flux:session>
    <form wire:submit='save' class="rounded p-4 space-y-4 bg-white dark:bg-neutral-700">
        <flux:input wire:model='reward' :label="'Hadiah Kunjungan'" required></flux:input>
        <flux:input wire:model='ratio' :label="'Rasio Komisi'" required></flux:input>
        <flux:input wire:model='minimum' :label="'Minimum Penukaran Poin'" required></flux:input>
        <flux:input wire:model='max' :label="'Maksimal Hari Driver Aktif'" required></flux:input>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
            </div>

            <x-action-message class="me-3" on="success">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</div>
