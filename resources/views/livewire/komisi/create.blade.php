<div>
    <flux:session>{{ $title }}</flux:session>
    <form wire:submit='save' class="rounded bg-white dark:bg-neutral-700 space-y-4 p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='transaksi_id' type="number" label="transaksi_id" required :readonly="$komisi ? true : false">
                </flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='persen' min="0" max="100" label="persen"
                    type="number" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model.live='nilai' type="number" label="nilai" readonly></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:select class="" wire:model.live='status' label="Status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="pending">Pending</option>
                    <option value="cair">Cair</option>
                    <option value="batal">Batal</option>
                </flux:select>
            </div>
        </div>

        @if (!$errors->any())
            <flux:button type="submit" variant="primary">Submit</flux:button>
        @endif
    </form>
</div>
