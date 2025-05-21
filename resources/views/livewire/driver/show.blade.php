<div>
    <flux:session>Driver alert: {{ $user->name }} ready to make your day richer and happier! </flux:session>
    <div class="rounded bg-white dark:bg-neutral-700 p-4">

        <div class="flex gap-4 items-start flex-wrap sm:flex-nowrap">
            <div class="aspect-square size-full bg-red-500 sm:size-52">asdfasdf</div>
            <div class="w-full">
                <div class="">Name: {{ $user->name }} </div>
                <div class="">Email: {{ $user->email }} </div>
                <div class="">Phone: {{ $user->phone }} </div>
                <div class="">Total Attendance: {{ $user->driver->attendance->count() }} </div>
                <div class="">Commision Balance: {{ number_format($user->driver->komisi/1000,0, ',', '.') }}K </div>
                <div class="">Commision Withdrawn: {{
                    number_format($user->driver->commisionWithdrawal->sum('amount')/1000,0, ',', '.') }}K </div>
            </div>
            <div class="aspect-video bg-center bg-no-repeat bg-cover p-4 rounded h-52"
                style="background-image: url({{ asset('storage/card.png') }})">asdfasdf</div>
        </div>
        <div class="mt-4" x-data="{show:5, field:'commision'}">
            <div class="flex gap-4 justify-center">
                <div x-on:click="show = 5;field = 'commision'" class="px-4 py-2 rounded cursor-pointer"
                    :class="field == 'commision' ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600'">Commision</div>
                <div x-on:click="show = 5;field = 'attendance'" class="px-4 py-2 rounded cursor-pointer"
                    :class="field == 'attendance' ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600'">Attendance</div>
                <div x-on:click="show = 5;field = 'withdrawn'" class="px-4 py-2 rounded cursor-pointer"
                    :class="field == 'withdrawn' ? 'bg-mine-200' : 'bg-gray-200 dark:bg-neutral-600'">Withdrawn</div>
            </div>
            <div class="overflow-x-auto mt-4" x-cloak x-show="field == 'commision'"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
                <div class="flex py-4 gap-4 min-w-5xl">
                    <div class="w-10 text-center">#</div>
                    <div class="w-1/6">Transaction Number</div>
                    <div class="w-1/6">Customer Info</div>
                    <div class="w-1/6">Product Sold</div>
                    <div class="w-1/6 text-center">Total Transaction</div>
                    <div class="w-1/6 text-center">Commision</div>
                    <div class="w-1/6 text-center">Note</div>
                </div>
                @foreach ($user->driver->transaction as $item)
                <div class="flex gap-4 items-center py-2 min-w-5xl">
                    <div class="w-10 text-center">{{ $loop->iteration }} </div>
                    <div class="w-1/6">{{ $item->transaction_number }} </div>
                    <div class="w-1/6">
                        <div class="">{{ $item->name }} </div>
                        <div class="text-xs md:text-sm">{{ $item->email }} </div>
                        <div class="text-xs md:text-sm">{{ $item->phone }} </div>
                    </div>
                    <div class="w-1/6">
                        @foreach ($item->transactionDetail as $itm)
                        <div class="text-nowrap">{{ $itm->product->name }} | {{ $itm->qty }} Pcs </div>
                        @endforeach
                    </div>
                    <div class="w-1/6 text-center">IDR {{ number_format($item->total_amount,0, ',', '.') }} </div>
                    <div class="w-1/6">
                        @if ($item->commision > 0)
                        <div class="">{{ $item->commision }} </div>
                        <div class="text-xs md:text-sm">{{ $item->driver->user->name }} </div>
                        @else
                        <div class="text-center">-</div>
                        @endif
                    </div>
                    <div class="w-1/6">{{ $item->note }} </div>
                </div>

                @endforeach
            </div>
            <div class="overflow-x-auto mt-4" x-cloak x-show="field == 'attendance'"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
                <div class="flex py-4 gap-4 items-center min-w-xl">
                    <div class="w-10 text-center">#</div>
                    <div class="w-2/5 md:w-1/4">Driver Info</div>
                    <div class="w-1/5 text-center md:w-1/4">The Customer He Brought</div>
                    <div class="w-1/5 text-center md:w-1/4">Sticker Number</div>
                    <div class="w-1/5 md:w-1/4 text-center">Checkin</div>
                </div>
                @foreach ($user->driver->attendance as $item)
                <div class="flex gap-4 items-center py-2 min-w-xl">
                    <div class="w-10 text-center">{{ $loop->iteration }} </div>
                    <div class="w-2/5 md:w-1/4">
                        <div class="">{{ $item->driver->user->name }} </div>
                        <div class="text-xs md:text-sm">{{ $item->driver->user->email }} </div>
                        <div class="text-xs md:text-sm">{{ $item->driver->user->phone }} </div>
                    </div>
                    <div class="w-1/5 text-center md:w-1/4">{{ $item->person }} </div>
                    <div class="w-1/5 text-center md:w-1/4">{{ $item->sticker_number }} </div>
                    <div class="w-1/5 md:w-1/4 text-center">{{ $item->created_at->format('d/m/Y H:i') }} </div>
                </div>
                @endforeach
            </div>
            <div class="overflow-x-auto mt-4" x-cloak x-show="field == 'withdrawn'"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="">
                <div class="flex py-4 gap-4 min-w-5xl">
                    <div class="w-10 text-center">#</div>
                    <div class="w-1/6">Driver Info</div>
                    <div class="w-1/6 text-center">Amount</div>
                    <div class="w-1/6 text-center">Withdrawn to</div>
                    <div class="w-1/6 text-center">Withdrawn Date</div>
                    <div class="w-1/6 text-center">Status</div>
                    <div class="w-1/6 text-center">Action</div>
                </div>
                @foreach ($user->driver->commisionWithdrawal as $key => $item)
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
                    <div class="w-1/6 flex justify-center gap-2">
                        @if (Auth::user()->role != 'driver' && $item->status == 'requested')
                        <flux:modal.trigger name="decline-{{ $key }}">
                            <flux:button icon="x-mark" iconVarian size="sm" square variant="danger">
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:button icon="check" href="{{ route('withdrawal.token', ['token'=> $item->token]) }}"  iconVarian size="sm" square as variant="primary">
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
</div>
