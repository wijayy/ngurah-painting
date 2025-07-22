<div>
    <flux:session>Driver Withdrawn Record</flux:session>

    <div class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="print:block hidden font-semibold">
            Data Penukaran Poin pada {{ $month }} {{ $year }}
        </div>
        <div class="print:hidden">
            <flux:button variant="primary" onclick="window.print()">Print</flux:button>
        </div>
        <div class="overflow-x-auto mt-4 print:overflow-x-hidden" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="">
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
            @foreach ($withdrawal as $key => $item)
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
