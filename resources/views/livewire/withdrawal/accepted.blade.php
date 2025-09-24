<div>
    <flux:session>{{ $title }}</flux:session>

    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <div class="font-semibold">{{ $title }}</div>
        <form wire:submit='save' class="mt-4" enctype="multipart/form-data">
            <input type="hidden" wire:model.live='expect'>
            {{-- <input type="hidden" name="confirmation_amount" value="{{ $expect }}"> --}}
            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model.live='id_penukaran' type="number" label="id_penukaran" readonly></flux:input>
                <flux:input wire:model.live='driver_id' type="number" label="driver_id" readonly></flux:input>

                <flux:input wire:model.live='poin' type="number" label="Poin Ditukar" readonly></flux:input>
                <flux:input wire:model.live='jumlah' type="number" label="Nominal" autofocus></flux:input>

                <flux:select wire:model.live='status' label="Metode Penukaran" required>
                    <flux:select.option value="ditolak">Ditolak</flux:select.option>
                    <flux:select.option value="disetujui">Disetujui</flux:select.option>
                </flux:select>

                <flux:input wire:model.live='bukti_url' type="string" label="bukti_url"
                    :required="$status == 'disetujui' ? true : false"></flux:input>

                <flux:input wire:model.live='diajukan_at' type="datetime-local" label="Diajukan_At"></flux:input>
                @if ($status == 'disetujui')
                    {{-- <flux:input wire:model.live='metode_penukaran' type="string" label="Metode_Penukaran" :required="true"></flux:input> --}}
                    <flux:input wire:model.live='disetujui_at' type="datetime-local" label="Disetujui_At"></flux:input>
                @else
                    <flux:input wire:model.live='ditolak_at' type="datetime-local" label="Ditolak_At"></flux:input>
                @endif
            </div>
            <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
        </form>
    </div>
</div>
