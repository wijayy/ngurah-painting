<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 space-y-4 p-4">
        <flux:separator text="Informasi Akun"></flux:separator>
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='name' label="Nama Driver" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='email' label="Email" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='nomor_telepon' type="number" placeholder="62XXXXXXXXXXX"
                    label="Nomor Telepon" required></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model.live='password' label="Password">
                </flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model.live='password_confirmation'
                    label="Confirm Password"></flux:input>
            </div>
        </div>
        <flux:separator c text="Informasi Driver"></flux:separator>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 ">
            <div class="">
                <flux:input type="file" wire:model.live='foto_ktp' aspect="video" preview="{{ $preview_ktp }}"
                    label="Foto KTP"></flux:input>
            </div>
            <div class="">
                <flux:input type="file" wire:model.live='foto_sim' aspect="video" preview="{{ $preview_sim }}"
                    label="Foto SIM"></flux:input>
            </div>
            <div class=""></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='membership_no' label="Membership No" disabled></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='token' label="Token" disabled></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='no_ktp' type="text" only_number label="NIK" required>
                </flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:select class="" wire:model.live='status' label="Status" required>
                    <flux:select.option value="aktif">Aktif</flux:select.option>
                    <flux:select.option value="non-aktif">Non Aktif</flux:select.option>
                    <flux:select.option value="draft">Draft</flux:select.option>
                    <flux:select.option value="suspend">Suspend</flux:select.option>
                </flux:select>
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='no_sim' only_number label="No. SIM" required></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="date" class="" wire:model.live='sim_berlaku_hingga'
                    label="SIM Berlaku Hingga" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='bank' label="Bank" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='nama_rekening' label="Nama Rekening" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='nomor_rekening' only_number type="number"
                    label="Nomor Rekening" required></flux:input>
            </div>
            <div class="md:col-span-6">
                <flux:textarea class="" wire:model.live='alamat' label="Alamat" required></flux:textarea>
            </div>

        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
