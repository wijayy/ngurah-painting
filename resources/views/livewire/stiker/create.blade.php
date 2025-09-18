<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded p-4 bg-white dark:bg-neutral-700">
        <div class="text-sm font-semibold">Buat Stiker (Kunjungan)</div>
        <div class="grid grid-cols-2 items-start gap-4 mt-4">
            <flux:select wire:model.live='driver_id' label="Driver_id" :readonly="$driver ? true : false">
                <flux:select.option value="">-- Pilih Driver --</flux:select.option>
                @foreach (\App\Models\Driver::all() as $driver)
                    <flux:select.option value="{{ $driver->id_driver }}">
                        {{ $driver->id_driver }} - {{ $driver->user->name }} - {{ $driver->membership_no }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:input class="" wire:model.live='nomor_stiker' type="text" only-number label="Nomor Stiker"></flux:input>
            <flux:input class="" wire:model.live='tanggal_waktu' type="datetime-local" label="tanggal waktu"></flux:input>
            <flux:input class="" wire:model.live='expired_at' type="datetime-local" label="expired at"></flux:input>
            <flux:input class="" wire:model.live='used_at' type="datetime-local" label="Used At"></flux:input>

            <flux:input class="" wire:model.live='jumlah' type="number" label="jumlah wisatawan"></flux:input>
            <flux:input class="" wire:model.live='nama' type="text" label="contact_nama"></flux:input>
            <flux:input class="" wire:model.live='wa' type="text" only-number label="Contact_wa"></flux:input>

            <div class="flex gap-4">
                <flux:button type="submit" variant="primary">Simpan Stiker</flux:button>
                <flux:button as href="{{ route('kunjungan') }}" >Batal</flux:button>
            </div>
        </div>
    </form>
</div>
