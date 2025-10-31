<div>
    <flux:session>Profil Driver</flux:session>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="rounded p-4 space-y-4 bg-white dark:bg-neutral-700">
            <div class="font-semibold">Profil</div>
            <div class=" flex justify-center w-full">
                {{ QrCode::size('200')->generate(route('attendance.token', ['token' => $user->driver->token])) }}
            </div>
            <div class="grid grid-cols-2">
                <div class="border-b py-1 uppercase">Field</div>
                <div class="border-b py-1 uppercase">Nilai</div>
                <div class="border-b py-1 ">Nama</div>
                <div class="border-b py-1 ">{{ $user->name }}</div>
                <div class="border-b py-1 ">Email</div>
                <div class="border-b py-1 ">{{ $user->email }}</div>
                <div class="border-b py-1 ">No. HP</div>
                <div class="border-b py-1 ">{{ $user->nomor_telepon }}</div>
                <div class="border-b py-1 ">Alamat</div>
                <div class="border-b py-1 ">{{ $user->driver->alamat }}</div>
                <div class="border-b py-1 ">Poin</div>
                <div class="border-b py-1 ">{{ $user->driver->poin }}</div>
            </div>
        </div>
        <div class="rounded p-4 bg-white overflow-x-auto dark:bg-neutral-700 md:col-span-2">
            <div class="font-semibold">Ringkasan Aktifitas</div>
            <div class="flex gap-4 py-2 border-b font-semibold min-w-md">
                <div class="w-2/5">Waktu</div>
                <div class="w-3/5">Aktifitas</div>
            </div>
            @foreach ($user->aktifitas as $item)
                <div class="flex gap-4 py-2 border-b min-w-md">
                    <div class="w-2/5">{{ $item->created_at->format('Y-m-d H:i') }}</div>
                    <div class="w-3/5">{{ $item->aktifitas }}</div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="rounded p-4 mt-4 bg-white overflow-x-auto dark:bg-neutral-700 md:col-span-2">
        <div class="font-semibold">History Poin</div>
        <div class="flex gap-4 py-2 border-b font-semibold min-w-md">
            <div class="w-1/6">Waktu</div>
            <div class="w-1/6">Poin</div>
            <div class="w-1/6">Status</div>
            <div class="w-3/6">Pesan</div>
        </div>
        @foreach ($user->driver->poins as $item)
            <div class="flex gap-4 py-2 border-b min-w-md">
                <div class="w-1/6">{{ $item->created_at->format('Y-m-d H:i') }}</div>
                <div class="w-1/6">{{ $item->poin }}</div>
                <div class="w-1/6">{{ $item->status }}</div>
                <div class="w-3/6">{{ $item->pesan }}</div>
            </div>
        @endforeach
    </div>
</div>
