<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-mine-100 dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="border-e border-zinc-200 print:hidden bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}"
            class="flex rounded-xl items-center p-2 border h-fit space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist>
            @if (Auth::user()->role != 'driver')
                <flux:navlist.item icon="layout-dashboard" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard'    )" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            @else
                <flux:navlist.item icon="user" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Profil') }}</flux:navlist.item>
            @endif
            @if (Auth::user()->role == 'admin')
                <flux:navlist.item icon="user" :href="route('driver.index')"
                    :current="request()->routeIs('driver.*')" wire:navigate>{{ __('Driver') }}</flux:navlist.item>
                <flux:navlist.item icon="box" :href="route('product.index')"
                    :current="request()->routeIs('product.*')" wire:navigate>{{ __('Produk') }}</flux:navlist.item>
                <flux:navlist.item icon="map-pin" :href="route('stiker.index')"
                    :current="request()->routeIs('stiker.*')" wire:navigate>{{ __('Buat Stiker') }}
                </flux:navlist.item>
                <flux:navlist.item icon="notepad-text" :href="route('transaction.index')"
                    :current="request()->routeIs('transaction.*')" wire:navigate>{{ __('Transaksi') }}
                </flux:navlist.item>
                <flux:navlist.item icon="plus-circle" :href="route('komisi.index')"
                    :current="request()->routeIs('komisi.*')" wire:navigate>{{ __('Komisi') }}
                </flux:navlist.item>
                <flux:navlist.item icon="credit-card" :href="route('pembayaran.index')"
                    :current="request()->routeIs('pembayaran.*')" wire:navigate>{{ __('Pembayaran') }}
                </flux:navlist.item>
                <flux:navlist.item icon="star" :href="route('withdrawal.index')"
                    :current="request()->routeIs('withdrawal.*')" wire:navigate>{{ __('Tukar Poin') }}
                </flux:navlist.item>

                @if (config('app.config'))
                    <flux:navlist.item icon="wrench-screwdriver" :href="route('config')"
                        :current="request()->routeIs('config')" wire:navigate>{{ __('Konfigurasi') }}
                    </flux:navlist.item>
                @endif
                <flux:navlist.item icon="users" :href="route('user.index')" :current="request()->routeIs('user.*')"
                    wire:navigate>{{ __('Staff') }}</flux:navlist.item>
            @endif

            @if (Auth::user()->role == 'staff')
                <flux:navlist.item icon="scan-line" :href="route('kunjungan')"
                    :current="request()->routeIs('kunjungan')" wire:navigate>{{ __('Kunjungan (Scan)') }}</flux:navlist.item>
                <flux:navlist.item icon="map-pin" :href="route('stiker.create')"
                    :current="request()->routeIs('stiker.*')" wire:navigate>{{ __('Buat Stiker') }}</flux:navlist.item>
                <flux:navlist.item icon="notepad-text" :href="route('transaction.index')"
                    :current="request()->routeIs('transaction.index')" wire:navigate>{{ __('Transaksi') }}</flux:navlist.item>
                <flux:navlist.item icon="plus" :href="route('transaction.create')"
                    :current="request()->routeIs('transaction.create')" wire:navigate>{{ __('Tambah Transaksi') }}</flux:navlist.item>
            @endif

            @if (Auth::user()->role == 'driver')
                <flux:navlist.item icon="credit-card" :href="route('withdrawal.request')"
                    :current="request()->routeIs('withdrawal.*')" wire:navigate>{{ __('Tukar Poin') }}
                </flux:navlist.item>
            @endif
        </flux:navlist>

        <flux:spacer />

        <flux:navlist>
            {{-- <flux:navlist.item icon="settings" :href="route('settings.profile')"
                :current="request()->routeIs('settings.*')" wire:navigate>{{ __('Pengaturan') }}</flux:navlist.item> --}}
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:navlist.item icon="log-out" type="submit">{{ __('Logout') }}</flux:navlist.item>
            </form>
            <div class="text-sm capita px-3">Masuk sebagai <span
                    class="font-semibold capitalize">{{ Auth::user()->role }}</span> </div>
        </flux:navlist>

        <!-- Desktop User Menu -->
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden print:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />


    </flux:header>

    {{ $slot }}

    @stack('scripts')
    @fluxScripts
    @livewireScripts
</body>

</html>
