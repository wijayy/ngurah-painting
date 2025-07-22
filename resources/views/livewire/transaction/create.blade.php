<div class="">
    <flux:session>Add Transaction</flux:session>

    <form wire:submit='save' class="grid grid-cols-1 lg:grid-cols-3 bg-white dark:bg-neutral-700 rounded p-4 gap-4">
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            </div>
            <div class="mt-4 space-y-4">
                @foreach ($products as $index => $product)
                    <div class="grid grid-cols-12 items-end gap-4">
                        <div class="col-span-9">
                            <flux:select wire:model="products.{{ $index }}.name" wire:change='updatePrice' :label="'Nama Produk'" required>
                                @foreach ($allProduct as $item)
                                    <flux:select.option value="{{ $item->id_produk }}">{{ $item->nama }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="col-span-2">
                            <flux:input wire:model="products.{{ $index }}.qty" min="1" wire:input='updatePrice' :label="'Jumlah'" type="number"
                                autocomplete="none" required>
                            </flux:input>
                        </div>
                        {{-- <div class="">{{ $product['max'] }}</div> --}}
                        <flux:button variant="danger" icon="trash" type="button" wire:click="removeProduct({{ $index }})"
                            class="text-red-500 hover:underline"></flux:button>
                    </div>
                @endforeach
                <flux:button type="button"  wire:click="addProduct" class="mt-2 border rounded p-2 w-full text-center">
                    <flux:icon.plus></flux:icon.plus>
                </flux:button>
            </div>
        </div>
        <div class="space-y-4 border-t-2 border-black pt-4 lg:pt-0 lg:border-s-2 lg:border-t-0 lg:pl-4">
            <flux:select wire:model="payment" :label="'Metode Pembayaran'">
                <flux:select.option value="cash">Cash</flux:select.option>
                <flux:select.option value="transfer">Transfer</flux:select.option>
            </flux:select>
            <flux:input wire:model="sticker" wire:input='changeSticker' :label="'Nomor Stiker'" type="number"></flux:input>
            <div class="text-xs lg:text-sm">{{ $driver->user->name ?? '' }}</div>
            <div class="mt-4 grid grid-cols-4">
                <div class="col-span-3">Total Transaction</div>
                <div class="text-end">IDR {{ number_format($total/1000,0, ',', '.') }}K</div>
                @if ($driver)
                    <div class="col-span-3">Commission Given</div>
                    <div class="text-end">IDR {{ number_format($commission/1000,0, ',', '.')  }}K</div>
                @endif
            </div>
            <flux:button type="submit" variant="primary">Submit</flux:button>
        </div>
    </form>

</div>
