@php
    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
@endphp

<div>
    <flux:session>{{ $title }}</flux:session>

    <div class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="print:block hidden font-semibold">
            Data Penukaran Poin pada {{ $month }} {{ $year }}
        </div>
        <div class="print:hidden flex space-x-2 items-center w-fit">
            {{-- <flux:input wire:model.live='month'></flux:input> --}}
            <flux:select wire:model.live='month'>
                <flux:select.option value="">-- Pilih Bulan --</flux:select.option>
                @foreach ($months as $num => $name)
                    <flux:select.option value="{{ $num }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input wire:model.live='year'></flux:input>
            <flux:button variant="primary" onclick="window.print()">Print</flux:button>
        </div>
        <div class="overflow-x-auto mt-4 print:overflow-x-hidden" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="">
            <div class="grid grid-cols-11 gap-4 print:min-w-0 print:text-2xs min-w-[1500px]">
                <div class=" ">ID_PENUKARAN</div>
                <div class="">DRIVER_ID</div>
                <div class=" ">POIN DITUKAR</div>
                <div class=" ">NOMINAL</div>
                <div class="col-span-2 ">METODE_PENUKARAN</div>
                <div class=" ">DIAJUKAN_AT</div>
                <div class="col-span-2 ">DISETUJUI/DITOLAK_AT</div>
                <div class=" ">STATUS</div>
                <div class="  print:hidden">AKSI</div>
            </div>
            @foreach ($withdrawal as $key => $item)
                <div class="grid grid-cols-11 gap-4 items-center print:min-w-0 print:text-2xs py-2 min-w-[1500px]">
                    <div class=" ">{{ $item->id_penukaran }} </div>
                    <div class="">
                        {{ $item->driver_id }}
                    </div>
                    <div class=" ">{{ $item->poin }}</div>
                    <div class=" ">IDR {{ number_format($item->jumlah, 0, ',', '.') }} </div>
                    <div class=" col-span-2 ">
                        @if ($item->metode_penukaran == 'cash')
                            Cash
                        @else
                            <div class="">{{ $item->nomor_rekening }} </div>
                            <div class="text-xs md:text-sm print:text-2xs">{{ $item->nama_rekening }} </div>
                            <div class="text-xs md:text-sm print:text-2xs">{{ $item->bank }} </div>
                        @endif
                    </div>
                    <div class=" ">{{ $item->created_at->format('d/m/Y H:i') }} </div>
                    <div class=" col-span-2 ">
                        @if ($item->status == 'disetujui' && $item->disetujui_at)
                            {{ $item->disetujui_at->format('d/m/Y H:i') }}
                        @elseif ($item->status == 'ditolak' && $item->ditolak_at)
                            {{ $item->ditolak_at->format('d/m/Y H:i') }}
                        @else
                            -
                        @endif
                    </div>
                    <div class="capitalize">{{ $item->status }}</div>
                    <div class="">
                        @if ($item->status == 'diajukan')
                            <a href="{{ route('withdrawal.token', ['token' => $item->token]) }}">Proses</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
