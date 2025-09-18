<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 gap-4 mb-4 md:mb-8 md:grid-cols-6">
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='name' label="Nama" required></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='email' label="Email" required></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='nomor_telepon' label="Nomor Telepon" required></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:select :label="'Role'" wire:model='role' required>
                    <flux:select.option value="staff">Staff</flux:select.option>
                    <flux:select.option value="admin">Admin</flux:select.option>
                </flux:select>
            </div>
            <div class="md:col-span-3">
                <flux:select :label="'Status'" wire:model='status' required>
                    <flux:select.option value="1">Active</flux:select.option>
                    <flux:select.option value="0">Inactive</flux:select.option>
                </flux:select>
            </div>
            <div class="md:col-span-3"></div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model.live='password' label="Kata Sandi"
                    :required="$user ? false : true">
                </flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model.live='password_confirmation'
                    label="Konfirmasi Kata sandi" :required="$user ? false : true"></flux:input>
            </div>
            <div class="md:col-span-6">
                <flux:textarea class="" wire:model.live='catatan' label="Catatan (Opsional)" rows="3"></flux:textarea>
            </div>
        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
