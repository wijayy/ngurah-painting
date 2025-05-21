<div>
    <flux:session>The Products We Sell</flux:session>
    <div class="rounded p-4 overflow-x-auto  bg-white dark:bg-neutral-700">
        {{-- <flux:button variant="primary" as href="{{ route('product.create') }}">Add Product </flux:button> --}}
        <div class="overflow-x-auto print:overflow-x-hidden mt-4 "
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
            <div class="flex py-4 gap-4 print:min-w-0 min-w-5xl">
                <div class="w-10 text-center">#</div>
                <div class="w-1/6">Transaction Number</div>
                <div class="w-1/6">Customer Info</div>
                <div class="w-1/6">Product Sold</div>
                <div class="w-1/6 text-center">Total Transaction</div>
                <div class="w-1/6 text-center">Commision</div>
                <div class="w-1/6 text-center">Note</div>
            </div>
            @foreach ($transaction as $item)
            <div class="flex gap-4 items-center py-2 min-w-5xl">
                <div class="w-10 text-center">{{ $loop->iteration }} </div>
                <div class="w-1/6">{{ $item->transaction_number }} </div>
                <div class="w-1/6">
                    <div class="">{{ $item->name }} </div>
                    <div class="text-xs md:text-sm">{{ $item->email }} </div>
                    <div class="text-xs md:text-sm">{{ $item->phone }} </div>
                </div>
                <div class="w-1/6">
                    @foreach ($item->transactionDetail as $itm)
                    <div class="text-nowrap">{{ $itm->product->name }} | {{ $itm->qty }} Pcs </div>
                    @endforeach
                </div>
                <div class="w-1/6 text-center">IDR {{ number_format($item->total_amount,0, ',', '.') }} </div>
                <div class="w-1/6 text-center">
                    {{-- @if ($item->commision > 0) --}}
                    {{-- <div class="">{{ $item->commision }} </div> --}}
                    <div class="">IDR {{ number_format($item->total_amount/2,0, ',', '.') }} </div>
                    <div class="text-xs md:text-sm">agus </div>
                    {{-- @else
                    <div class="text-center">-</div>
                    @endif --}}
                </div>
                <div class="w-1/6">{{ $item->note }} </div>
            </div>

            @endforeach
        </div>
    </div>
</div>
