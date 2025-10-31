<div>
    <flux:session>Transaksi</flux:session>
    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <form class="flex gap-4 items-center print:hidden">
            <flux:input wire:model.live='search' placeholder="Cari nomor_transaksi/nomor_stiker"></flux:input>
            <flux:select wire:model.live="status" class="w-fit!">
                <flux:select.option value="">Semua Status</flux:select.option>
                <flux:select.option value="selesai">Selesai</flux:select.option>
                <flux:select.option value="draft">Draft</flux:select.option>
                <flux:select.option value="dibatalkan">Dibatalkan</flux:select.option>
            </flux:select>
            <flux:button variant="primary" as href="{{ route('transaction.create') }}">Tambah Transaksi</flux:button>
            <flux:button variant="primary" onclick="window.print()">Print</flux:button>
        </form>

        <div class="mt-4 print:hidden gap-4 flex">
            @if (Auth::user()->role == 'staff')
            @endif

        </div>
        <div class="overflow-x-auto print:overflow-x-hidden mt-4 " x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="">
            <div class="flex py-4 gap-4 print:min-w-0 print:text-2xs min-w-5xl">
                <div class="uppercase font-semibold text-sm w-32 ">id_transaksi</div>
                <div class="uppercase font-semibold text-sm w-1/6 text-center">Nomor_Transaksi</div>
                <div class="uppercase font-semibold text-sm w-1/6 text-center">Tanggal</div>
                <div class="uppercase font-semibold text-sm w-1/6 text-center ">stiker</div>
                <div class="uppercase font-semibold text-sm w-1/6 text-center ">status</div>
                <div class="uppercase font-semibold text-sm w-1/6 text-center ">total_harga</div>
                <div class="uppercase font-semibold text-sm w-1/6 text-center  print:hidden">aksi</div>
            </div>
            @foreach ($transaction as $key => $item)
                <div class="flex gap-4 items-center py-2 print:min-w-0 print:text-2xs min-w-5xl">
                    <div class="w-32 ">{{ $item->id_transaksi }} </div>
                    <div class="w-1/6 text-center">{{ $item->nomor_transaksi }} </div>
                    <div class="w-1/6 text-center">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i') }}
                    </div>
                    <div class="w-1/6 text-center">
                        @if ($item->stiker)
                            <div class="">{{ $item->stiker->nomor_stiker }}</div>
                            <div class="">{{ $item->stiker->driver->nama }}</div>
                        @else
                            <div class="">-</div>
                        @endif
                    </div>

                    <div class="w-1/6 text-center ">
                        {{ $item->status }}
                    </div>
                    <div class="w-1/6 text-center ">
                        IDR {{ number_format($item->total_harga, 0, ',', '.') }}
                    </div>
                    <div class="w-1/6 text-center flex print:hidden justify-center">
                        <flux:tooltip content="Lihat Detail">
                            <div class=" cursor-pointer w-full" wire:click='detailTransaksi({{ $item->id_transaksi }})'>
                                Detail</div>
                        </flux:tooltip>
                        @if ($item->komisi && !$item->komisi?->pembayaran)
                            <flux:tooltip content="Cairkan Komisi">
                                <a class=" cursor-pointer w-full"
                                    href="{{ route('pembayaran.create', ['slug' => $item->komisi->slug]) }}">
                                    Cairkan Komisi</a>
                            </flux:tooltip>
                        @endif

                    </div>
                </div>
            @endforeach
            <flux:modal name="detail">
                <div class="p-4">
                    <div class="text-lg font-semibold mb-4">Detail Transaksi</div>
                    @if ($transaksi)
                        <div class="mb-2"><strong>ID Transaksi:</strong> {{ $transaksi->id_transaksi }}</div>
                        <div class="mb-2"><strong>Nomor Transaksi:</strong> {{ $transaksi->nomor_transaksi }}</div>
                        <div class="mb-2"><strong>Tanggal:</strong>
                            {{ \Carbon\Carbon::parse($transaksi->created_at)->format('Y-m-d H:i') }}</div>
                        <div class="mb-2 "><strong>Status:</strong> {{ $transaksi->status }}
                        </div>
                        @if ($transaksi->komisi)
                            <flux:separator></flux:separator>
                            <div class="">Nomor Stiker : {{ $transaksi->stiker->nomor_stiker }}</div>
                            <div class="">Jumlah Komisi : Rp.
                                {{ number_format($transaksi->komisi->nilai, 0, ',', '.') }}
                            </div>
                            <div class="">Status : {{ $transaksi->komisi->status }}</div>

                            @if ($transaksi->komisi->status == 'cair')
                                <div class="w-full mt-4">
                                    <img src="{{ asset('storage/' . $transaksi->komisi->pembayaran->bukti_transfer) }}"
                                        alt="asdfasdf">
                                </div>
                            @endif
                        @endif

                        <div class="mt-4"></div>

                        <flux:separator></flux:separator>

                        <div class="">
                            @foreach ($transaksi->transactionDetail as $item)
                                <div class="mb-2 border-b border-gray-300 pb-2">
                                    <div><strong>Produk:</strong> {{ $item->product->nama }}</div>
                                    <div><strong>Jumlah:</strong> {{ $item->jumlah }}</div>
                                    <div><strong>Harga Satuan:</strong> IDR
                                        {{ number_format($item->harga, 0, ',', '.') }}</div>
                                    <div><strong>Subtotal:</strong> IDR
                                        {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-2"><strong>Total Harga:</strong> IDR
                            {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                        <!-- Tambahkan detail lainnya sesuai kebutuhan -->
                    @else
                        <div>Memuat detail transaksi...</div>
                    @endif
                </div>
            </flux:modal>
        </div>
    </div>
</div>
