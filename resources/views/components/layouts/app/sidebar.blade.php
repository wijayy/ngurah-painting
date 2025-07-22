<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-mine-100 dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="border-e border-zinc-200 print:hidden bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist>
            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            @if (Auth::user()->role != 'driver')
                <flux:navlist.item icon="archive-box" :href="route('product.index')"
                    :current="request()->routeIs('product.*')" wire:navigate>{{ __('Produk') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('driver.index')" :current="request()->routeIs('driver.*')"
                    wire:navigate>{{ __('Driver') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('transaction.index')"
                    :current="request()->routeIs('transaction.*')" wire:navigate>{{ __('Transaksi') }}</flux:navlist.item>
                <flux:navlist.item icon="banknotes" :href="route('withdrawal.index')"
                    :current="request()->routeIs('withdrawal.*')" wire:navigate>{{ __('Tukar Poin') }}</flux:navlist.item>
                <flux:navlist.item icon="home" :href="route('attendance.index')"
                    :current="request()->routeIs('attendance.*')" wire:navigate>{{ __('Kunjungan') }}</flux:navlist.item>
            @endif
            @if (Auth::user()->role == 'admin')
                @if (config('app.config'))
                    <flux:navlist.item icon="wrench-screwdriver" :href="route('config')" :current="request()->routeIs('config')"
                        wire:navigate>{{ __('Konfigurasi') }}</flux:navlist.item>
                @endif
                <flux:navlist.item icon="users" :href="route('user.index')" :current="request()->routeIs('user.*')"
                    wire:navigate>{{ __('Staff') }}</flux:navlist.item>
            @endif
            @if (Auth::user()->role == 'driver')
                <flux:navlist.item icon="banknotes" :href="route('withdrawal.request')"
                    :current="request()->routeIs('withdrawal.*')" wire:navigate>{{ __('Tukar Poin') }}
                </flux:navlist.item>
            @endif
        </flux:navlist>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden print:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @stack('scripts')
    @fluxScripts
    @livewireScripts
</body>

</html>
