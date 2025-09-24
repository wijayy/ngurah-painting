<div>
    <flux:session>{{ $title }}</flux:session>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="md:col-span-2 rounded bg-white dark:bg-neutral-700 p-4">
            <div class="">Ringkasan</div>
            <canvas class="max-h-96 mt-4" id="transactionChart"></canvas>
        </div>
        <div class="rounded col-span-1 space-y-4 bg-white dark:bg-neutral-700 p-4">
            <div class="font-semibold">Aksi Cepat</div>
            <div class="grid grid-cols-1 gap-4 text-start!">
                <flux:button as href="{{ route('kunjungan') }}">Scan QR</flux:button>
                <flux:button as href="{{ route('stiker.create') }}">Buat Stiker</flux:button>
                <flux:button as href="{{ route('transaction.create') }}">Tambah Transaksi</flux:button>
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
            responsive: true,
            maintainAspectRatio: false,
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
