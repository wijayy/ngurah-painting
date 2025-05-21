<div>
    <flux:session>Driver Withdrawn Record</flux:session>

    <div class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="print:block hidden font-semibold">
            Driver Withdrawal Record on May 2025
        </div>
        <div class="overflow-x-auto print:mt-4 print:overflow-x-hidden" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="">
            <div class="flex gap-4 print:min-w-0 min-w-5xl">
                <div class="w-10 text-center">#</div>
                <div class="w-1/6">Driver Info</div>
                <div class="w-1/6 text-center">Amount</div>
                <div class="w-1/6 text-center">Withdrawn to</div>
                <div class="w-1/6 text-center">Withdrawn Date</div>
                <div class="w-1/6 text-center">Status</div>
                <div class="w-1/6 text-center print:hidden">Action</div>
            </div>
            @foreach ($withdrawal as $key => $item)
            <div class="flex gap-4 items-center py-2 min-w-5xl">
                <div class="w-10 text-center">{{ $loop->iteration }} </div>
                <div class="w-1/6">
                    <div class="">{{ $item->driver->user->name }} </div>
                    <div class="text-xs md:text-sm">{{ $item->driver->user->email }} </div>
                    <div class="text-xs md:text-sm">{{ $item->driver->user->phone }} </div>
                </div>
                <div class="w-1/6 text-center">IDR {{ number_format($item->amount,0, ',', '.') }} </div>
                <div class="w-1/6 text-center">
                    @if ($item->withdrawal_method == 'cash')
                    Cash
                    @else
                    <div class="">{{ $item->driver->account_number }} </div>
                    <div class="text-xs md:text-sm">{{ $item->driver->account_name }} </div>
                    <div class="text-xs md:text-sm">{{ $item->driver->bank }} </div>
                    @endif
                </div>
                <div class="w-1/6 text-center">{{ $item->created_at->format('d/m/Y H:i') }} </div>
                <div class="w-1/6 text-center">{{ $item->status }} </div>
                <div class="w-1/6 flex justify-center print:hidden gap-2">
                    @if (Auth::user()->role != 'driver' && $item->status == 'requested')
                    <flux:modal.trigger name="decline-{{ $key }}">
                        <flux:button icon="x-mark" iconVarian size="sm" square variant="danger">
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:button icon="check" href="{{ route('withdrawal.token', ['token'=> $item->token]) }}"
                        iconVarian size="sm" square as variant="primary">
                    </flux:button>
                    <flux:modal name="decline-{{ $key }}">
                        <flux:heading size='lg' class="">Decline Commision Withdrawal</flux:heading>
                        <div class="">Are you sure to decline {{ $item->driver->user->name }} request withdrawal? </div>
                        <div class="flex justify-end w-full mt-4">
                            <flux:modal.close>
                                <flux:button wire:click='decline({{ $item }});' variant="danger">Decline</flux:button>
                            </flux:modal.close>
                        </div>
                    </flux:modal>
                    @endif
                    @if ($item->status =='accepted')
                    <flux:modal.trigger name="accepted-{{ $key }}">
                        <flux:button icon="eye" iconVarian size="sm" square as variant="primary">
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:modal name="accepted-{{ $key }}">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="">
                    </flux:modal>
                    @endif
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>
