<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 space-y-4 p-4">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                <span class="block sm:inline">Silakan periksa input Anda.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($this->status === 'cair')
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <flux:input type="file" wire:model.live="bukti_transfer" preview="{{ $preview_bukti_transfer }}"
                    label="Bukti Transfer"></flux:input>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">

            {{-- @dd($nomor_transaksi) --}}
            <div class="md:col-span-3">
                <flux:input class="" wire:model.live='nomor_transaksi' readonly label="Nomor Transaksi" required>
                </flux:input>
                @if ($this->komisi)
                    <div class="text-sm mt-4 text-green-600">Komisi ditemukan: Nilai = {{ $this->komisi->nilai }}</div>
                @endif
            </div>
            <div class="md:col-span-3">
                <flux:select wire:model.live='status' label="Status" required>
                    <flux:select.option value="">-- Pilih Status --</flux:select.option>
                    <flux:select.option value="cair">Cair</flux:select.option>
                    <flux:select.option value="batal">Batal</flux:select.option>
                </flux:select>
            </div>
            @if ($this->status === 'cair')


                <div class="md:col-span-3">
                    <flux:input class="" wire:model.live='amount' type="number" label="Amount" readonly>
                    </flux:input>

                </div>
                <div class="md:col-span-3">
                    <flux:select class="" wire:model.live='metode' label="Metode Pembayaran" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </flux:select>
                </div>
                @if ($this->metode === 'transfer')
                    <div class="md:col-span-3">
                        <flux:input class="" wire:model.live='bank' type="text" label="Bank"></flux:input>
                    </div>
                    <div class="md:col-span-3">
                        <flux:input class="" wire:model.live='nama_rekening' type="text" label="Nama Rekening">
                        </flux:input>
                    </div>
                    <div class="md:col-span-3">
                        <flux:input class="" wire:model.live='nomor_rekening' type="text"
                            label="Nomor Rekening">
                        </flux:input>
                    </div>

                    <div class="md:col-span-3">
                        <flux:input class="" wire:model.live='waktu_pembayaran' type="datetime-local"
                            label="Waktu Transfer">
                        </flux:input>
                    </div>
                @endif
                <div class="md:col-span-3">
                    <flux:input class="" wire:model.live='nomor_referensi' type="text" label="Nomor Referensi">
                    </flux:input>
                </div>
            @endif
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
