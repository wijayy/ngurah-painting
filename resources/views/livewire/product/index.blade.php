<div>
    <flux:session>The Products We Sell</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        <flux:button variant="primary" as href="{{ route('product.create') }}">Add Product </flux:button>
        <div class="grid grid-cols-12 py-2 gap-4 min-w-3xl font-semibold items-center">
            <div class="w-10 text-center">#</div>
            <div class="flex col-span-3 gap-1 items-center">
                Product
            </div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-2 text-center">Stock</div>
            <div class="col-span-2 text-center">Sold</div>
            <div class="col-span-2 text-center">Actions</div>
        </div>
        @foreach ($product as $key => $item)
        <div class="grid grid-cols-12 py-2 gap-4 min-w-3xl items-center">
            <div class="w-10 text-center">{{ $key+1 }} </div>
            <div class="flex col-span-3 gap-1 items-center">
                <div class="size-10 aspect-square bg-center bg-cover bg-no-repeat"
                    style="background-image: url({{ asset('storage/' . $item->image) }})"></div>
                <div class="">{{ $item->name }} </div>
            </div>
            <div class="col-span-2 text-center">IDR {{ number_format($item->price,0, ',', '.') }} </div>
            <div class="col-span-2 text-center">{{ $item->stock }} </div>
            <div class="col-span-2 text-center">{{ $item->transactionDetail->sum('qty') }} </div>
            <div class="col-span-2 text-center flex gap-2 justify-center">
                <flux:button icon="pencil-square" iconVarian size="sm" square as
                    href="{{ route('product.edit', ['slug' => $item->slug]) }}" variant="primary">
                </flux:button>
                <flux:modal.trigger name="delete-{{ $key }}">
                    <flux:button icon="trash" size="sm" square variant="danger">
                    </flux:button>
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
