<div>
    <flux:session>Add Driver</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 gap-4 mb-4 md:mb-8 md:grid-cols-4">
            <div class="md:col-span-4">
                <div class="md:w-1/2">
                    <flux:input type="file" wire:model.live='foto_ktp' :label="'Foto KTP'"></flux:input>
                </div>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='nama' label="Nama Driver" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='email' label="Email" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='no_telepon' type="number" placeholder="62XXXXXXXXXXX" label="Nomor Telepon" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='no_ktp' type="number" label="NIK" required></flux:input>
            </div>

            <div class="md:col-span-2">
                <flux:input type="password" viewable class="" wire:model.live='password' label="Password" required>
                </flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input type="password" viewable class="" wire:model.live='password_confirmation' label="Confirm Password"
                    required></flux:input>
            </div>
        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
