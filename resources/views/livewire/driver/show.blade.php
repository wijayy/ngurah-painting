<div>
    <flux:session>Driver alert: {{ $user->name }} ready to make your day richer and happier! </flux:session>
    <div class="rounded bg-white dark:bg-neutral-700 p-4">

        <div class="flex gap-4 items-start flex-wrap sm:flex-nowrap">
            <div class="aspect-square size-full sm:size-52">
                {{ QrCode::size('200')->generate(route('attendance.token', ['token' => $user->driver->token])) }}
            </div>
            <div class="w-full">
                <div class="">Name: {{ $user->name }} </div>
                <div class="">Email: {{ $user->email }} </div>
                <div class="">Phone: {{ $user->driver->no_telepon }} </div>
                <div class="">Poin: {{ $user->driver->poin }} </div>
                <div class="">Total Kunjungan: {{ $user->driver->attendance->count() }} </div>
                <div class="">Commision Balance:
                    {{ number_format($user->driver->komisi->whereNull('pembayaran')->sum('komisi') / 1000, 0, ',', '.') }}K
                </div>
                <div class="">Commision Withdrawn: {{
    number_format($user->driver->komisi->whereNotNull('pembayaran')->sum('komisi') / 1000, 0, ',', '.') }}K </div>
            </div>
            <div class="aspect-video bg-center flex flex-col bg-no-repeat bg-cover p-4 rounded h-52"
                style="background-image: url({{ asset('storage/card.png') }})">
                <div class="text-lg lg:text-xl">{{ $user->driver->bank }}</div>
                <div class="h-full"></div>
                <div class="font-semibold text-lg lg:text-xl">{{ $user->driver->account_number }}</div>
                <div class="text-sm lg:text-base">{{ $user->driver->account_name }}</div>
            </div>
        </div>
        <div class="mt-4" x-data="{show:5, field:'commision'}">
            <div class="flex gap-4 justify-center">
                <div x-on:click="show = 5;field = 'commision'" class="px-4 py-2 rounded cursor-pointer"
                    :class="field == 'commision' ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600'">Komisi</div>
                <div x-on:click="show = 5;field = 'attendance'" class="px-4 py-2 rounded cursor-pointer"
                    :class="field == 'attendance' ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600'">Kunjungan</div>
                <div x-on:click="show = 5;field = 'withdrawn'" class="px-4 py-2 rounded cursor-pointer"
                    :class="field == 'withdrawn' ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600'">Penukaran Poin
                </div>
            </div>
            <div class="overflow-x-auto mt-4" x-cloak x-show="field == 'commision'"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
                <div class="flex py-4 gap-4 print:min-w-0 print:text-2xs min-w-5xl">
                    <div class="w-10 text-center">#</div>
                    <div class="w-1/6">Nomor Transaksi</div>
                    <div class="w-1/6">Produk Terjual</div>
                    <div class="w-1/6 text-center">Total</div>
                    <div class="w-1/6 text-center">Komisi</div>
                    <div class="w-1/6 text-center">Status Komisi</div>
                    <div class="w-1/6 text-center print:hidden">Action</div>
                </div>
                @foreach ($user->driver->transaksi as $key => $item)
                    <div class="flex gap-4 items-center py-2 print:min-w-0 print:text-2xs min-w-5xl">
                        <div class="w-10 text-center">{{ $loop->iteration }} </div>
                        <div class="w-1/6">{{ $item->nomor_transaksi }} </div>
                        <div class="w-1/6">
                            @foreach ($item->transactionDetail as $itm)
                                <div class="text-nowrap print:text-wrap">{{ $itm->product->nama }} | {{ $itm->jumlah }} Pcs
                                </div>
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
                                        <flux:modal.trigger name="bukti-{{ $key }}">
                                            <flux:button variant="primary" icon="eye"></flux:button>
                                        </flux:modal.trigger>
                                    </flux:tooltip>
                                    <flux:modal name="bukti-{{ $key }}">
                                        {{-- <div class="">asfdadsfasdfsadfasd</div> --}}
                                        <img class="" src="{{ asset('storage/' . $item->komisi->pembayaran->bukti_pembayaran) }}"
                                            alt="">
                                    </flux:modal>
                                @else
                                    <flux:tooltip content="Cairkan Komisi">
                                        <flux:button as href="{{ route('transaction.withdrawal', ['slug' => $item->slug]) }}"
                                            variant="primary" icon="banknotes"></flux:button>
                                    </flux:tooltip>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="overflow-x-auto mt-4" x-cloak x-show="field == 'attendance'"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
                <div class="flex py-4 gap-4 items-center min-w-xl">
                    <div class="w-10 text-center">#</div>
                    <div class="w-2/5 md:w-1/4">Info Driver</div>
                    <div class="w-1/5 text-center md:w-1/4">Jumlah Customer</div>
                    <div class="w-1/5 text-center md:w-1/4">Nomor Stiker</div>
                    <div class="w-1/5 md:w-1/4 text-center">Checkin</div>
                </div>
                @foreach ($user->driver->attendance as $item)
                    <div class="flex gap-4 items-center py-2 min-w-xl">
                        <div class="w-10 text-center">{{ $loop->iteration }} </div>
                        <div class="w-2/5 md:w-1/4">
                            <div class="">{{ $item->driver->user->name }} </div>
                            <div class="text-xs md:text-sm">{{ $item->driver->user->email }} </div>
                            <div class="text-xs md:text-sm">{{ $item->driver->no_telepon }} </div>
                        </div>
                        <div class="w-1/5 text-center md:w-1/4">{{ $item->jumlah_customer }} </div>
                        <div class="w-1/5 text-center md:w-1/4">{{ $item->nomor_stiker }} </div>
                        <div class="w-1/5 md:w-1/4 text-center">{{ $item->created_at->format('d/m/Y H:i') }} </div>
                    </div>
                @endforeach
            </div>
            <div class="overflow-x-auto mt-4" x-cloak x-show="field == 'withdrawn'"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
                <div class="flex gap-4 print:min-w-0 print:text-2xs min-w-5xl">
                <div class="w-10 text-center">#</div>
                <div class="w-1/6">Info Driver</div>
                <div class="w-1/6 text-center">Poin</div>
                <div class="w-1/6 text-center">Jumlah</div>
                <div class="w-1/6 text-center">Metode Penukaran</div>
                <div class="w-1/6 text-center">Waktu Penukaran</div>
                <div class="w-1/6 text-center">Status</div>
                <div class="w-1/6 text-center print:hidden">Action</div>
            </div>
            @foreach ($user->driver->tukar_poin as $key => $item)
                <div class="flex gap-4 items-center print:min-w-0 print:text-2xs py-2 min-w-5xl">
                    <div class="w-10 text-center">{{ $loop->iteration }} </div>
                    <div class="w-1/6">
                        <div class="">{{ $item->driver->user->name }} </div>
                        <div class="text-xs md:text-sm text-wrap print:text-2xs">{{ $item->driver->user->email }} </div>
                        <div class="text-xs md:text-sm print:text-2xs">{{ $item->driver->no_telepon }} </div>
                    </div>
                    <div class="w-1/6 text-center">{{ $item->poin }}</div>
                    <div class="w-1/6 text-center">IDR {{ number_format($item->jumlah, 0, ',', '.') }} </div>
                    <div class="w-1/6 text-center">
                        @if ($item->withdrawal_method == 'cash')
                            Cash
                        @else
                            <div class="">{{ $item->driver->nomor_rekening }} </div>
                            <div class="text-xs md:text-sm print:text-2xs">{{ $item->driver->nama_rekening }} </div>
                            <div class="text-xs md:text-sm print:text-2xs">{{ $item->driver->bank }} </div>
                        @endif
                    </div>
                    <div class="w-1/6 text-center">{{ $item->created_at->format('d/m/Y H:i') }} </div>
                    <div class="w-1/6 text-center">{{ $item->status }} </div>
                    <div class="w-1/6 flex justify-center print:hidden gap-2">
                        @if (Auth::user()->role != 'driver' && $item->status == 'diajukan')
                            <flux:modal.trigger name="decline-{{ $key }}">
                                <flux:tooltip content="Tolak">
                                    <flux:button icon="x-mark" iconVarian size="sm" square variant="danger">
                                    </flux:button>
                                </flux:tooltip>
                            </flux:modal.trigger>
                            <flux:tooltip content="Terima">
                                <flux:button icon="check" href="{{ route('withdrawal.token', ['token' => $item->token]) }}"
                                    iconVarian size="sm" square as variant="primary">
                                </flux:button>
                            </flux:tooltip>
                            <flux:modal name="decline-{{ $key }}">
                                <flux:heading size='lg' class="">Tolak Penukaran Poin</flux:heading>
                                <div class="">Apakah anda yakin menolak Penukaran Poin {{ $item->driver->user->name }}? </div>
                                <div class="flex justify-end w-full mt-4">
                                    <flux:modal.close>
                                        <flux:button wire:click='decline({{ $item }});' variant="danger">Tolak</flux:button>
                                    </flux:modal.close>
                                </div>
                            </flux:modal>
                        @endif
                        @if ($item->status == 'sukses')
                            <flux:modal.trigger name="accepted-{{ $key }}">
                                <flux:tooltip content="Bukti Penukaran">
                                    <flux:button icon="eye" iconVarian size="sm" square as variant="primary">
                                    </flux:button>
                                </flux:tooltip>
                            </flux:modal.trigger>
                            <flux:modal name="accepted-{{ $key }}">
                                <img src="{{ asset('storage/' . $item->bukti_penukaran) }}" alt="">
                            </flux:modal>
                        @endif
                    </div>
                </div>

            @endforeach
            </div>
        </div>
    </div>
</div>
