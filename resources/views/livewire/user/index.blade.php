<div>
    <flux:session>Staff</flux:session>
    <div class="rounded p-4 bg-white overflow-x-auto dark:bg-neutral-700">
        <flux:button variant="primary" as href="{{ route('user.create') }}">Tambah Staff</flux:button>
        <div class="flex min-w-3xl font-semibold py-4">
            <div class="w-10">#</div>
            <div class="w-1/4 ">Name</div>
            <div class="w-1/4 ">Email</div>
            <div class="w-1/4 ">Role</div>
            <div class="w-1/4 ">Aksi</div>
        </div>
        @foreach ($users as $key => $item)
            <div class="flex min-w-3xl py-1">
                <div class="w-10">{{ $key + 1 }}</div>
                <div class="w-1/4 ">{{ $item->name }}</div>
                <div class="w-1/4 ">{{ $item->email }}</div>
                <div class="w-1/4 ">{{ $item->role }}</div>
                <div class="w-1/4 ">
                    @if ($item->isNot(Auth::user()))
                    <a href="{{ route('user.edit', $item->slug) }}">Edit</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
