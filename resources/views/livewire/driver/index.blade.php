<div>
    <flux:session>People Who Bring Customer`s Money</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        <flux:button variant="primary" as href="{{ route('driver.create') }}">Add Drivers </flux:button>
        <div class="grid grid-cols-14 py-2 gap-4 min-w-3xl font-semibold items-center">
            <div class="w-10 text-center">#</div>
            <div class="flex col-span-3 gap-1 items-center">
                Profile
            </div>
            <div class="col-span-2 ">Informasi Bank</div>
            <div class="col-span-2 text-center">Komisi Dicairkan</div>
            <div class="col-span-2 text-center">Komisi Tertahan</div>
            <div class="col-span-2 text-center">Poin</div>
            <div class="col-span-2 text-center">Actions</div>
        </div>
        @foreach ($drivers as $key => $item)
            <div class="grid grid-cols-14 py-2 gap-4 min-w-3xl items-center">
                <div class="w-10 text-center">{{ $key + 1 }} </div>
                <div class="col-span-3 gap-1 items-center">
                    <flux:heading size="lg" class="">{{ $item->name }} </flux:heading>
                    <div class="">{{ $item->email }} </div>
                    <a class="underline" href="https://wa.me/{{ $item->driver->nomor_telepon }}" class="">{{ $item->driver->nomor_telepon }} </a>
                </div>
                <div class="col-span-2 gap-1">
                    @if ($item->driver->bank ?? false)
                        <flux:heading size="lg" class="">{{ $item->driver->nomor_rekening }} </flux:heading>
                        <div class="">{{ $item->driver->nama_rekening }} </div>
                        <div class="">{{ $item->driver->bank }} </div>
                    @else
                        <div class="">-</div>
                    @endif
                </div>
                <div class="col-span-2 text-center">IDR
                    {{ number_format($item->driver->komisi->whereNotNull('pembayaran')->sum('komisi'), 0, ',', '.')  }}
                </div>
                <div class="col-span-2 text-center">IDR {{ number_format($item->driver->komisi->whereNull('pembayaran')->sum('komisi'), 0, ',', '.')  }} </div>
                <div class="col-span-2 text-center">{{ $item->driver->poin }} </div>
                <div class="col-span-2 text-center flex gap-2 justify-center">
                    <flux:tooltip content="Detail Driver">
                        <flux:button icon="eye" iconVarian size="sm" square as
                            href="{{ route('driver.show', ['slug' => $item->slug]) }}" variant="primary">
                        </flux:button>
                    </flux:tooltip>
                    <flux:modal.trigger name="delete-{{ $key }}">
                        <flux:tooltip content="Delete Driver">

                            <flux:button icon="trash" size="sm" class="cursor-pointer" square variant="danger">
                            </flux:button>
                        </flux:tooltip>
                    </flux:modal.trigger>
                </div>
            </div>
            <flux:modal name="delete-{{ $key }}">
                <flux:heading size='lg' class="">Delete Produk</flux:heading>
                <div class="">Are you sure to delete produk {{ $item->name }}? </div>
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
