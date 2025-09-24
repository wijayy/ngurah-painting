<x-layouts.app title="{{ Auth::user()->role == 'driver' ? 'Profil' : 'Dashboard' }}">
    @if (Auth::user()->role == 'driver')
        <livewire:driver.profile class=""></livewire:driver.profile>
    @elseif (Auth::user()->role == 'admin')
        <livewire:dashboard class=""></livewire:dashboard>
    @elseif (Auth::user()->role == 'staff')
        <livewire:staff.dashboard class=""></livewire:staff.dashboard>
    @endif
</x-layouts.app>
