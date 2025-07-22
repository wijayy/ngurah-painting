<div>
    <flux:session>Staff</flux:session>
    <div class="rounded p-4 bg-white overflow-x-auto dark:bg-neutral-700">
        <flux:button variant="primary" as href="{{ route('user.create') }}">Tambah Staff</flux:button>
        <div class="flex min-w-3xl font-semibold py-4">
            <div class="">#</div>
            <div class="w-1/5 text-center">Name</div>
            <div class="w-1/5 text-center">Email</div>
            <div class="w-1/5 text-center">Role</div>
            <div class="w-1/5 text-center">Verified</div>
            <div class="w-1/5 text-center">Action</div>
        </div>
        @foreach ($users as $key => $item)
            <div class="flex min-w-3xl py-1">
                <div class="">{{ $key + 1 }}</div>
                <div class="w-1/5 text-center">{{ $item->name }}</div>
                <div class="w-1/5 text-center">{{ $item->email }}</div>
                <div class="w-1/5 text-center">{{ $item->role }}</div>
                <div class="w-1/5 text-center flex justify-center">
                    @if ($item->email_verified_at)
                        <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Interface / Check_All">
                                    <path id="Vector"
                                        d="M8 12.4854L12.2426 16.728L20.727 8.24268M3 12.4854L7.24264 16.728M15.7279 8.24268L12.5 11.5001"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                    @else
                        <svg width="36px" height="36px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M16 8L8 16M8.00003 8L10 10M16 16L12 12" stroke="#000000" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    @endif
                </div>
                <div class="w-1/5 text-center">
                    @if ($item->isNot(Auth::user()))

                        <flux:modal.trigger name="delete-{{ $key }}">
                            <flux:tooltip content="Delete User">
                                <flux:button icon="trash" size="sm" square variant="danger">
                                </flux:button>
                            </flux:tooltip>
                        </flux:modal.trigger>
                        <flux:modal name="delete-{{ $key }}">
                            <flux:heading size='lg' class="">Delete User</flux:heading>
                            <div class="">Apakah anda yaking menghapus Staff {{ $item->name }}? </div>
                            <div class="flex justify-end w-full mt-4">
                                <flux:modal.close>
                                    <flux:button wire:click='delete({{ $item }});' variant="danger">Hapus</flux:button>
                                </flux:modal.close>
                            </div>
                        </flux:modal>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
