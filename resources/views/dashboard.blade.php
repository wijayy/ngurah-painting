<x-layouts.app title="Dashboard">
    @if (Auth::user()->role == 'driver')
        <livewire:driver.show class=""></livewire:driver.show>
    @else
        <livewire:dashboard class=""></livewire:dashboard>
    @endif
</x-layouts.app>
