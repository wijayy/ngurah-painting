<div>
    <flux:session>{{ $title }}</flux:session>
    <div class="rounded p-4 bg-white overflow-x-auto dark:bg-neutral-700">
        <flux:button as href="{{ route('komisi.create') }}">Tambah Komisi</flux:button>
        <div class="flex min-w-3xl font-semibold py-4">
            <div class="uppercase w-28">id_komisi</div>
            <div class="uppercase w-1/6 ">transaksi_id</div>
            <div class="uppercase w-1/6 ">persen</div>
            <div class="uppercase w-1/6 ">nilai</div>
            <div class="uppercase w-1/6 ">status</div>
            <div class="uppercase w-1/6 ">created_at</div>
            <div class="uppercase w-1/6 ">Aksi</div>
        </div>
        @foreach ($komisi as $key => $item)
            <div class="flex min-w-3xl py-1">
                <div class="w-28">{{ $item->id_komisi }}</div>
                <div class="w-1/6 ">{{ $item->transaksi_id }}</div>
                <div class="w-1/6 ">{{ $item->persen }} %</div>
                <div class="w-1/6 ">{{ number_format($item->nilai,0, ',', '.')  }}</div>
                <div class="w-1/6 ">{{ $item->status }}</div>
                <div class="w-1/6 ">{{ $item->created_at->format('Y-m-d') }}</div>
                <div class="w-1/6 ">
                    <a href="{{ route('komisi.edit', $item->id_komisi) }}">Edit</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
