@php
    $months = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Aug',
        9 => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec',
    ]
@endphp

<div>
    <flux:session>Transaksi</flux:session>
    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <form class="flex gap-4 items-center print:hidden">
            <flux:select wire:model.live="month" wire:change="changeDate" class="w-fit!">
                @foreach ($months as $key => $item)
                    <flux:select.option value="{{ $key }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model.live="year" wire:change="changeDate" class="w-fit!">
                @foreach (range(date('Y'), 2025, -1) as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
            <div class="">Summary</div>
        </form>

        <div class="hidden font-semibold print:block">Data Transaksi pada {{ $months[$month] }} {{ $year }}</div>


        {{-- <flux:button variant="primary" as href="{{ route('product.create') }}">Add Product </flux:button> --}}
        {{-- <div class="overflow-x-auto mt-4 print:hidden">
            <div class="grid gap-4 min-w-3xl grid-cols-5">
                <div class="flex flex-col aspect-video bg-mine-200 rounded items-center gap-4 justify-center">
                    <div class=" text-xl lg:text-3xl font-bold">
                        IDR {{ number_format($transaction->sum('total_amount') / 1000, 0, ',', '.') }}K
                    </div>
                    <div class="lg:text-lg text-center ">Earnings</div>
                </div>
                <div class="flex flex-col aspect-video bg-mine-200 rounded items-center gap-4 justify-center">
                    <div class=" text-xl lg:text-3xl font-bold">
                        IDR {{ number_format($transaction->sum('komisi') / 1000, 0, ',', '.') }}K
                    </div>
                    <div class="lg:text-lg text-center ">Commission Given</div>
                </div>
                <div class="flex flex-col aspect-video bg-mine-200 rounded items-center gap-4 justify-center">
                    <div class=" text-xl lg:text-3xl font-bold">{{ $transaction->count() }}</div>
                    <div class="lg:text-lg text-center ">Transaction Count</div>
                </div>
                <div class="flex flex-col aspect-video bg-mine-200 rounded items-center gap-4 justify-center">
                    <div class=" text-xl lg:text-3xl font-bold">{{ $transaction->where('komisi', '>', 0)->count() }}
                    </div>
                    <div class="lg:text-lg text-center ">Transaction with Commission Count</div>
                </div>
                <div class="flex flex-col aspect-video bg-mine-200 rounded items-center gap-4 justify-center">
                    <div class=" text-xl lg:text-3xl font-bold">{{ $transaction->sum('total_item') }} Pcs</div>
                    <div class="lg:text-lg text-center ">Product Sold</div>
                </div>
            </div>
        </div> --}}

        <div class="mt-4 print:hidden gap-4 flex">
            @if (Auth::user()->role == 'staff')
            <flux:button variant="primary" as href="{{ route('transaction.create') }}">Tambah Transaksi</flux:button>
            @endif
            <flux:button variant="primary" onclick="window.print()">Print</flux:button>
        </div>
        <div class="overflow-x-auto print:overflow-x-hidden mt-4 " x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="">
            <div class="flex py-4 gap-4 print:min-w-0 print:text-2xs min-w-5xl">
                <div class="w-10 text-center">#</div>
                <div class="w-1/6">Nomor Transaksi</div>
                <div class="w-1/6">Produk Terjual</div>
                <div class="w-1/6 text-center">Total</div>
                <div class="w-1/6 text-center">Komisi</div>
                <div class="w-1/6 text-center">Status Komisi</div>
                <div class="w-1/6 text-center print:hidden">Action</div>
            </div>
            @foreach ($transaction as $key => $item)
                <div class="flex gap-4 items-center py-2 print:min-w-0 print:text-2xs min-w-5xl">
                    <div class="w-10 text-center">{{ $loop->iteration }} </div>
                    <div class="w-1/6">{{ $item->nomor_transaksi }} </div>
                    <div class="w-1/6">
                        @foreach ($item->transactionDetail as $itm)
                            <div class="text-nowrap print:text-wrap">{{ $itm->product->nama }} | {{ $itm->jumlah }} Pcs </div>
                        @endforeach
                    </div>
                    <div class="w-1/6 text-center">IDR {{ number_format($item->total_harga, 0, ',', '.') }} </div>

                    <div class="w-1/6 text-center">
                        @if ($item->komisi)
                            {{-- <div class="">{{ $item->commision }} </div> --}}
                            <div class="">IDR {{ number_format($item->komisi->komisi, 0, ',', '.') }} </div>
                            <div class="text-xs md:text-sm">{{ $item->stiker->driver->user->name }} </div>
                        @else
                            <div class="text-center">-</div>
                        @endif
                    </div>
                    <div class="w-1/6 text-center">
                        @if (!$item->komisi)
                            <div class="">Tidak Memiliki Komisi</div>
                        @else
                            @if ($item->komisi->pembayaran)
                                <div class="">Sudah Dicairkan</div>
                            @else
                                <div class="">Belum Dicairkan</div>
                            @endif
                        @endif
                    </div>
                    <div class="w-1/6 flex items-center print:hidden">
                        @if ($item->komisi)
                            @if ($item->komisi->pembayaran)
                                <flux:tooltip content="Lihat Bukti Pencairan">
                                    <flux:modal.trigger name="bukti-{{ $key }}" >
                                        <flux:button variant="primary" icon="eye"></flux:button>
                                    </flux:modal.trigger>
                                </flux:tooltip>
                                <flux:modal name="bukti-{{ $key }}">
                                    {{-- <div class="">asfdadsfasdfsadfasd</div> --}}
                                    <img class="" src="{{ asset('storage/' . $item->komisi->pembayaran->bukti_pembayaran) }}" alt="">
                                </flux:modal>
                            @else
                                <flux:tooltip content="Cairkan Komisi">
                                    <flux:button as href="{{ route('transaction.withdrawal', ['slug'=>$item->slug]) }}" variant="primary" icon="banknotes"></flux:button>
                                </flux:tooltip>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
