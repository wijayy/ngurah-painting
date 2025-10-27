<div class="">
    <flux:session>{{ $title }}</flux:session>

    <form wire:submit='save' class="bg-white dark:bg-neutral-700 rounded p-4 gap-4">
        <div class="">
            <div class="grid grid-cols-1 items-start lg:grid-cols-2 gap-4">
                <flux:input wire:model.live="nomor_transaksi" :label="'Nomor Transaksi'" type="text" readonly>
                </flux:input>
                <flux:input wire:model.live="tanggal" :label="'Tanggal'" type="datetime-local" required></flux:input>
                <div class="">
                    <flux:input wire:model.live='stiker' value="6" wire:input='changeStiker' only-number label="Nomor stiker">
                    </flux:input>
                    @if ($driver)
                        <div class="text-xs mt-4 lg:text-sm text-sky-400">Komisi diberikan kepada {{ $driver->user->name ?? '' }}
                        </div>
                    @elseif($driver === null && $stiker)
                        <div class="text-xs mt-4 lg:text-sm text-red-500">Driver tidak ditemukan</div>
                    @endif
                </div>
                <flux:select wire:model.live='status' label="Status">
                    <flux:select.option value="selesai">Selesai</flux:select.option>
                    <flux:select.option value="draft">Draft</flux:select.option>
                    <flux:select.option value="dibatalkan">Dibatalkan</flux:select.option>
                </flux:select>
            </div>
            <div class="mt-4 space-y-4">
                @foreach ($products as $index => $product)
                    <div class="grid grid-cols-12 items-end gap-4">
                        <div class="col-span-6">
                            <flux:select wire:model="products.{{ $index }}.produk_id"
                                wire:change="produkChanged({{ $index }})" :label="'Nama Produk'" required>
                                <flux:select.option value="">Pilih Produk</flux:select.option>
                                @foreach ($allProduct as $item)
                                    <flux:select.option value="{{ $item->id_produk }}">{{ $item->nama }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="col-span-2">
                            <flux:input wire:model="products.{{ $index }}.jumlah" wire:input='countTotal()'
                                min="1" :label="'Jumlah'" type="number" autocomplete="none" required>
                            </flux:input>
                        </div>
                        <div class="col-span-3">
                            <flux:input wire:model="products.{{ $index }}.subtotal" wire:input='countTotal()' readonly 
                                 :label="'Subtotal'" type="number" autocomplete="none" required>
                            </flux:input>
                        </div>
                        {{-- <div class="">{{ $product['max'] }}</div> --}}
                        <flux:button type="button" wire:click="removeProdukItem({{ $index }})">Hapus
                        </flux:button>
                    </div>
                @endforeach
                <flux:button icon="plus" type="button" wire:click="addProdukItem" class="mt-2">
                    Tambah Item
                </flux:button>
            </div>
            <div class="rounded p-2 md:w-1/2 mt-4 shadow">
                <flux:input format_number wire:model.live='total' label='Total harga' readonly></flux:input>
            </div>
        </div>

        <div class="mt-4 flex gap-4">
            <flux:button type="submit" variant="primary">Simpan Transaksi</flux:button>
            <flux:button as href="{{ route('transaction.index') }}">Batal</flux:button>
        </div>
    </form>

</div>
