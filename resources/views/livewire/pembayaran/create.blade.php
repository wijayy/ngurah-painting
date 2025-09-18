<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 space-y-4 p-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='komisi_id' type="number" label="Komisi ID" required
                    :readonly="$pembayaran ? true : false">
                </flux:input>
                @if ($this->komisi)
                    <div class="text-sm mt-4 text-green-600">Komisi ditemukan: Nilai = {{ $this->komisi->nilai }}</div>
                @endif
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='amount' type="number" label="Amount" readonly></flux:input>

            </div>
            <div class="md:col-span-3">
                <flux:select class="" wire:model.live='metode' label="Metode Pembayaran" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                </flux:select>
            </div>
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='bukti_transfer_url' type="text"
                    label="Bukti Transfer URL" required></flux:input>
            </div>
            @if ($this->metode === 'transfer')
                <div class="md:col-span-2">
                    <flux:input class="" wire:model.live='bank' type="text" label="Bank"></flux:input>
                </div>
                <div class="md:col-span-2">
                    <flux:input class="" wire:model.live='nama_rekening' type="text" label="Nama Rekening">
                    </flux:input>
                </div>
                <div class="md:col-span-2">
                    <flux:input class="" wire:model.live='nomor_rekening' type="text" label="Nomor Rekening">
                    </flux:input>
                </div>
            @endif
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='nomor_referensi' type="text" label="Nomor Referensi">
                </flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:select wire:model.live='status' label="Status" required>
                    <flux:select.option value="">-- Pilih Status --</flux:select.option>
                    <flux:select.option value="pending">Pending</flux:select.option>
                    <flux:select.option value="cair">Cair</flux:select.option>
                    <flux:select.option value="batal">Batal</flux:select.option>
                </flux:select>
            </div>
            <div class="md:col-span-6">
                <flux:textarea class="" wire:model.live='catatan' type="text" label="Catatan"></flux:textarea>
            </div>

            {{-- <flux:select class="" wire:model.live='status' label="Status" required>
                    <option value="">-- Pilih Status --</option> --}}
        </div>

        @if (!$errors->any())
            <flux:button type="submit" variant="primary">Submit</flux:button>
        @endif
    </form>
</div>
