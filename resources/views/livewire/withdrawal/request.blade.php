<div>
    <flux:session>Driver Demans His Rights</flux:session>
    <form wire:submit='save' class="rounded p-4 bg-white dark:bg-neutral-700">
        <div class="">
            <div class="">Name: {{ $user->name }} </div>
            <div class="">Email: {{ $user->email }} </div>
            <div class="">Phone: {{ $user->driver->no_telepon }} </div>
            <div class="">Poin: {{ number_format($user->driver->poin, 0, ',', '.') }} </div>
        </div>
        @if (!$user->driver->bank ?? false)
            <div class="mt-4 text-red-400">
                Kamu belum menambahkan akun bank di sistem, jadi saat ini kamu hanya bisa menarik dana secara tunai dan
                mengambilnya langsung di outlet. Klik <a class="underline underline-offset-2" href="#">di sini</a> untuk
                menambahkan akun bank.
            </div>
        @endif
        <div class="grid grid-cols-1 items-start mt-4 gap-4 md:grid-cols-2">
            <div class="">
                <flux:input wire:model.live='amount' required :label="'Poin Ditukarkan'" type="number"
                    max="{{ $user->driver->komisi }}" min="10" max="{{ $max }}"></flux:input>
                <div class="mt-4">Rp. {{ number_format($jumlah, 0, ',', '.') }}</div>
            </div>
            <flux:select wire:model.live='metode_penukaran' required :label="'Metode Penukaran'">
                <flux:select.option value="cash">Cash</flux:select.option>
                @if ($user->driver->bank ?? false)
                    <flux:select.option value="transfer">Transfer</flux:select.option>
                @endif
            </flux:select>
        </div>
        <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
    </form>
</div>
