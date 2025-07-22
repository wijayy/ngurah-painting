<div>
    <flux:session>Produk</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        <flux:button variant="primary" as href="{{ route('product.create') }}">Tambah Produk </flux:button>
        <div class="grid grid-cols-10 py-2 gap-4 min-w-3xl font-semibold items-center">
            <div class="w-10 text-center">#</div>
            <div class="flex col-span-3 gap-1 items-center">
                Nama Produk
            </div>
            <div class="col-span-2 text-center">Harga</div>
            <div class="col-span-2 text-center">Terjual</div>
            <div class="col-span-2 text-center">Actions</div>
        </div>
        @foreach ($product as $key => $item)
            <div class="grid grid-cols-10 py-2 gap-4 min-w-3xl items-center">
                <div class="w-10 text-center">{{ $key + 1 }} </div>
                <div class="flex col-span-3 gap-1 items-center">
                    {{ $item->nama }}
                </div>
                <div class="col-span-2 text-center">IDR {{ number_format($item->harga, 0, ',', '.') }} </div>
                <div class="col-span-2 text-center">{{ $item->transactionDetail->sum('jumlah') }} </div>
                <div class="col-span-2 text-center flex gap-2 justify-center">
                    <flux:tooltip content="Edit Product">
                        <flux:button icon="pencil-square" iconVarian size="sm" square as
                            href="{{ route('product.edit', ['slug' => $item->slug]) }}" variant="primary">
                        </flux:button>
                    </flux:tooltip>
                    <flux:modal.trigger name="delete-{{ $key }}">
                        <flux:tooltip content="Delete Product">
                            <flux:button icon="trash" size="sm" square variant="danger">
                            </flux:button>
                        </flux:tooltip>
                    </flux:modal.trigger>
                </div>
            </div>
            <flux:modal name="delete-{{ $key }}">
                <flux:heading size='lg' class="">Delete product</flux:heading>
                <div class="">Are you sure to delete product {{ $item->name }}? </div>
                <div class="flex justify-end w-full mt-4">
                    <flux:modal.close>
                        <flux:button wire:click='delete({{ $item }});' variant="danger">Delete</flux:button>
                    </flux:modal.close>
                </div>
            </flux:modal>
        @endforeach
    </div>
</div>

<script>

</script>
