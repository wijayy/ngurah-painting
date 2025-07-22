@php
    $month = [
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
    <flux:session>Dashboard</flux:session>
    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="aspect-video flex flex-col size-full rounded bg-neutral-600 text-white p-4">
                <svg fill="#fff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 76.991 76.992"
                    xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <g>
                                <g>
                                    <g>
                                        <path
                                            d="M46.387,75.839h-5.812c-0.639,0-1.24-0.248-1.692-0.697c-0.458-0.463-0.707-1.063-0.707-1.701l0.016-51.524 c0-0.64,0.25-1.243,0.703-1.696c0.456-0.454,1.058-0.702,1.696-0.702l5.604,0.008c1.32,0.005,2.394,1.079,2.396,2.394v0.048 c2.803-2.202,6.19-3.28,10.262-3.28c10.512,0,18.14,8.825,18.14,20.983c0,15.145-9.986,22.042-19.265,22.042 c-3.352,0-6.428-0.868-8.94-2.491v14.219C48.786,74.763,47.71,75.839,46.387,75.839z M41.176,72.839h4.61V56.038 c0-0.615,0.375-1.167,0.946-1.396c0.572-0.227,1.225-0.082,1.646,0.367c2.247,2.387,5.566,3.702,9.349,3.702 c7.834,0,16.265-5.959,16.265-19.042c0-10.42-6.367-17.983-15.14-17.983c-4.492,0-7.957,1.571-10.588,4.803 c-0.398,0.492-1.063,0.68-1.664,0.467c-0.597-0.211-0.998-0.775-1-1.409l-0.008-3.023l-4.4-0.006L41.176,72.839z M57.816,54.72 c-6.789,0-12.313-6.51-12.313-14.51s5.524-14.509,12.313-14.509c6.791,0,12.316,6.509,12.316,14.509S64.607,54.72,57.816,54.72z M57.816,28.702c-5.135,0-9.313,5.163-9.313,11.509s4.179,11.51,9.313,11.51c5.138,0,9.316-5.164,9.316-11.51 S62.954,28.702,57.816,28.702z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M34.844,56.259H28.25c-1.124,0-2.137-0.709-2.52-1.768l-7.107-19.626h-6.889v18.713c0,1.478-1.202,2.681-2.68,2.681 H2.681C1.203,56.259,0,55.056,0,53.579V3.873c0-1.475,1.199-2.677,2.673-2.681l12.233-0.04c7.523,0,12.485,1.457,16.095,4.722 c3.068,2.707,4.765,6.748,4.765,11.365c0,6.011-1.837,10.229-6.297,14.32l7.885,21.082c0.305,0.825,0.19,1.744-0.305,2.461 C36.543,55.829,35.72,56.259,34.844,56.259z M28.474,53.259h5.909l-8.084-21.615c-0.221-0.59-0.049-1.254,0.429-1.665 c4.402-3.772,6.039-7.226,6.039-12.741c0-3.744-1.336-6.986-3.764-9.128c-3.031-2.742-7.373-3.959-14.091-3.959L3.001,4.19 v49.069h5.733V33.366c0-0.829,0.671-1.5,1.5-1.5h9.441c0.631,0,1.195,0.396,1.41,0.989L28.474,53.259z M15.575,27.669h-5.341 c-0.829,0-1.5-0.671-1.5-1.5V9.927c0-0.828,0.67-1.499,1.498-1.5l5.117-0.006c0.004-0.001,0.012,0,0.019,0 c9.64,0.107,11.664,5.253,11.664,9.552C27.031,23.772,22.427,27.669,15.575,27.669z M11.734,24.669h3.841 c5.216,0,8.456-2.566,8.456-6.697c0-2.77-0.9-6.462-8.688-6.552l-3.609,0.004V24.669z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                <div class="text-xl md:text-2xl pt-4 font-semibold">{{ number_format($earnings / 1000, 0, ',', '.')  }}K
                </div>
                <div class="md:text-lg font-semibold">Pendapatan</div>
                <div class="text-xs font-semibold md:text-sm @if ($earningsDiff > 0)
                    text-mine-200
                @else
                    text-rose-500
                @endif ">{{ $earningsDiff>0 ? 'naik' : 'turun' }} {{ $earningsDiff }}% dari bulan lalu</div>
            </div>
            <div class="aspect-video flex flex-col size-full rounded bg-neutral-600 text-white p-4">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M16 3.98999H8C6.93913 3.98999 5.92178 4.41135 5.17163 5.1615C4.42149 5.91164 4 6.92912 4 7.98999V17.99C4 19.0509 4.42149 20.0682 5.17163 20.8184C5.92178 21.5685 6.93913 21.99 8 21.99H16C17.0609 21.99 18.0783 21.5685 18.8284 20.8184C19.5786 20.0682 20 19.0509 20 17.99V7.98999C20 6.92912 19.5786 5.91164 18.8284 5.1615C18.0783 4.41135 17.0609 3.98999 16 3.98999Z"
                            stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M9 2V7" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M15 2V7" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M8 16H14" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M8 12H16" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
                <div class="text-xl md:text-2xl pt-4 font-semibold">{{ $transaction }}
                </div>
                <div class="md:text-lg font-semibold">Transaksi</div>
                <div class="text-xs font-semibold md:text-sm @if ($transactionDiff > 0)
                    text-mine-200
                @else
                    text-rose-500
                @endif ">{{ $transactionDiff>0 ? 'naik' : 'turun' }} {{ $transactionDiff }}% dari bulan lalu</div>
            </div>
            <div class="aspect-video flex flex-col size-full rounded bg-neutral-600 text-white p-4">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M10 13H14M19 13V20H5V9M5 9H19C19.5523 9 20 8.55228 20 8V5C20 4.44772 19.5523 4 19 4H12M5 9C4.44772 9 4 8.55228 4 8V5C4 4.44772 4.44772 4 5 4H7"
                            stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <div class="text-xl md:text-2xl pt-4 font-semibold">{{ $sold }}
                </div>
                <div class="md:text-lg font-semibold">Produk Terjual</div>
                <div class="text-xs font-semibold md:text-sm @if ($soldDiff > 0)
                    text-mine-200
                @else
                    text-rose-500
                @endif ">{{ $soldDiff>0 ? 'naik' : 'turun' }} {{ $soldDiff }}% dari bulan lalu</div>
            </div>
            <div class="aspect-video flex flex-col size-full rounded bg-neutral-600 text-white p-4">
                <svg fill="#fff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 490 490"
                    xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path
                                d="M418.242,71.759C371.969,25.484,310.443,0,245,0C179.559,0,118.034,25.484,71.758,71.759C25.484,118.032,0,179.558,0,245 c0,65.441,25.484,126.967,71.758,173.241C118.034,464.516,179.559,490,245,490c65.443,0,126.969-25.484,173.242-71.759 S490,310.441,490,245C490,179.558,464.516,118.032,418.242,71.759z M245,42.15c102.528,0,187.52,76.464,200.979,175.358 L306.29,179.714c-16.024-15.049-37.573-24.285-61.29-24.285s-45.266,9.235-61.29,24.285L44.021,217.509 C57.48,118.614,142.473,42.15,245,42.15z M44.021,272.491l134.108,37.267l25.059,133.748 C120.11,426.027,55.6,357.562,44.021,272.491z M245,292.068c-25.994,0-47.068-21.073-47.068-47.068s21.074-47.068,47.068-47.068 s47.066,21.073,47.066,47.068S270.994,292.068,245,292.068z M286.814,443.506l25.058-133.748l134.106-37.267 C434.401,357.562,369.89,426.027,286.814,443.506z">
                            </path>
                        </g>
                    </g>
                </svg>
                <div class="text-xl md:text-2xl pt-4 font-semibold">{{ $attendance }}
                </div>
                <div class="md:text-lg font-semibold">Kunjungan Driver</div>
                <div class="text-xs font-semibold md:text-sm @if ($attendanceDiff > 0)
                    text-mine-200
                @else
                    text-rose-500
                @endif ">{{ $attendanceDiff>0 ? 'naik' : 'turun' }} {{ $attendanceDiff }}% dari bulan lalu</div>
            </div>
        </div>
        <div class="grid grid-cols-1 mt-4 lg:grid-cols-2 gap-4">
            <div class="">
                <div class="font-semibold">Kunjungan Driver</div>
                <div class="overflow-x-auto mt-4" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    class="">
                    <div class="flex py-4 gap-4 items-center min-w-xl">
                        <div class="w-10 text-center">#</div>
                        <div class="w-2/5 md:w-1/4">Info Driver</div>
                        <div class="w-1/5 text-center md:w-1/4">Jumlah Customer</div>
                        <div class="w-1/5 text-center md:w-1/4">Nomor Stiker</div>
                        <div class="w-1/5 md:w-1/4 text-center">Checkin</div>
                    </div>
                    @foreach ($attendances as $item)
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
                <a href="{{ route('attendance.index') }}" class="underline underline-offset-2">Kunjungan Lebih Banyak</a>
            </div>
            <div class="">
                <div class="font-semibold">Latest Transaction</div>
                <div class="overflow-x-auto print:overflow-x-hidden mt-4 "
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    class="">
                    <div class="flex py-4 gap-4 print:min-w-0 print:text-2xs">
                        <div class="w-10 text-center">#</div>
                        <div class="w-1/4">Nomor Transaksi</div>
                        <div class="w-1/4">Produk Terjual</div>
                        <div class="w-1/4 text-center">Total</div>
                        <div class="w-1/4 text-center">Komisi</div>
                    </div>
                    @foreach ($transactions as $key => $item)
                        <div class="flex gap-4 items-center py-2 print:min-w-0 print:text-2xs">
                            <div class="w-10 text-center">{{ $loop->iteration }} </div>
                            <div class="w-1/4">{{ $item->nomor_transaksi }} </div>
                            <div class="w-1/4">
                                @foreach ($item->transactionDetail as $itm)
                                    <div class="text-nowrap print:text-wrap">{{ $itm->product->nama }} | {{ $itm->jumlah }} Pcs
                                    </div>
                                @endforeach
                            </div>
                            <div class="w-1/4 text-center">IDR {{ number_format($item->total_harga, 0, ',', '.') }} </div>

                            <div class="w-1/4 text-center">
                                @if ($item->komisi)
                                    {{-- <div class="">{{ $item->commision }} </div> --}}
                                    <div class="">IDR {{ number_format($item->komisi->komisi, 0, ',', '.') }} </div>
                                    <div class="text-xs md:text-sm">{{ $item->stiker->driver->user->name }} </div>
                                @else
                                    <div class="text-center">-</div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
                <a href="{{ route('transaction.index') }}" class="underline underline-offset-2">Transaksi Lebih Banyak</a>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4 lg:grid-cols-6 ">
            <div class="flex flex-col gap-2 col-span-2 ">
                <div class="font-semibold">Peringkat Komisi Driver</div>
                @foreach ($topDrivers as $item)
                    @php
                        $width = $item->komisi_sum_komisi / $topCommission * 100;
                    @endphp
                    <div class="bg-gradient-to-r flex justify-between p-2  from-transparent to-mine-200 rounded"
                        style="width: {{ $width }}%">
                        <div class="">{{ $item->user->name }}</div>
                        <div class="">IDR {{ number_format($item->komisi_sum_komisi / 1000, 0, ',', '.') }}K</div>
                    </div>
                @endforeach
            </div>
            <div class="col-span-3 order-last lg:order-2">
                <h2 class="text-2xl font-bold mb-4">Pertumbuhan Pendapatan</h2>
                <canvas id="transactionChart" class="h-20 lg:h-36"></canvas>
            </div>
            <div class="order-2 lg:order-last">
                <div class="">Bulan Terbaik</div>
                <div class="md:text-xl font-semibold">{{ $month[$topMonthYear->month] }} {{ $topMonthYear->year }}</div>
                <div class="mt-4">Tahun Terbaik</div>
                <div class="md:text-xl font-semibold"> {{ $topYear->year }}</div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('transactionChart').getContext('2d');
    const transactionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Amount',
                data: @json($totals),
                fill: true,
                borderColor: '#ffb22c',
                backgroundColor: '#ffb22c24',
                tension: 0.4,
                pointRadius: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString()
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
