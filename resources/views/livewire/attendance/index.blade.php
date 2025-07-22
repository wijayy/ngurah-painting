<div>
    <flux:session>Kunjungan Driver</flux:session>
    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <form class="flex gap-4 items-center print:hidden">
            <flux:input wire:model.live="date" type="date" max="{{ date('Y-m-d') }}" wire:change="changeDate"
                class="w-fit!">
            </flux:input>
            <div class="">Summary</div>
        </form>
        <div class="mt-4 print:hidden">
            @if (Auth::user()->role == 'staff')
                <flux:button variant="primary" as href="{{ route('attendance.create') }}">Catat Kunjungan
                </flux:button>
            @endif
            <flux:button variant="primary" onclick="window.print()">Print</flux:button>
        </div>
        <div class="hidden print:block">Data Kunjungan Driver {{ Carbon\Carbon::make($date)->format('d M Y') }}</div>
        <div class="overflow-x-auto mt-4" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="">
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
    </div>
</div>
