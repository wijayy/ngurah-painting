<div>
    <flux:session>Tambah Staff</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 gap-4 mb-4 md:mb-8 md:grid-cols-6">
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='name' label="Nama Staff" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='email' label="Email" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:select :label="'Role'" wire:model='role' required>
                    <flux:select.option value="staff">Staff</flux:select.option>
                    <flux:select.option value="admin">Admin</flux:select.option>
                </flux:select>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model.live='password' label="Password" required>
                </flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model.live='password_confirmation'
                    label="Confirm Password" required></flux:input>
            </div>
        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
