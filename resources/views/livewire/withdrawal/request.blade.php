<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded p-4 bg-white dark:bg-neutral-700">
        <div class="grid grid-cols-1 items-start mt-4 gap-4 md:grid-cols-6">
            <div class="md:col-span-3">
                <flux:input wire:model='user_id' label='Driver_id' readonly></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input wire:model='max' label='Poin tersedia' readonly></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input wire:model.live='poin' required :label="'Poin ditukarkan'" type="number" min="10"
                    max="{{ $max }}"></flux:input>
                {{-- <div class="mt-4">Rp. {{ number_format($jumlah, 0, ',', '.') }}</div> --}}
            </div>
            <div class="md:col-span-3">
                <flux:input wire:model.live='jumlah' required :label="'Nominal (rp)'" type="number" readonly></flux:input>
                {{-- <div class="mt-4">Rp. {{ number_format($jumlah, 0, ',', '.') }}</div> --}}
            </div>

            <div class="md:col-span-3">
            <flux:select wire:model.live='metode_penukaran' required :label="'Metode Penukaran'">
                <flux:select.option value="cash">Cash</flux:select.option>
                <flux:select.option value="transfer">Transfer</flux:select.option>
            </flux:select>
            </div>
            <div class="md:col-span-3">
                <flux:input wire:model='status' label='status' readonly></flux:input>
            </div>
            @if ($metode_penukaran == 'transfer')
                <div class="md:col-span-2">
                    <flux:input wire:model.live='bank' required :label="'Bank'" type="text"></flux:input>
                </div>
                <div class="md:col-span-2">
                    <flux:input wire:model.live='nama_rekening' required :label="'Nama Rekening'" type="text">
                    </flux:input>
                </div>
                <div class="md:col-span-2">
                    <flux:input wire:model.live='nomor_rekening' only-number required :label="'Nomor Rekening'"
                        type="text"></flux:input>
                </div>
            @endif



        </div>
        <div class="mt-4 flex gap-4">
            <flux:button type="submit" variant="primary" class="mt-4">Ajukan</flux:button>
            <flux:button  class="mt-4" wire:click='default'>Batal</flux:button>
        </div>

        {{-- <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button> --- IGNORE --- --}}
    </form>
</div>
