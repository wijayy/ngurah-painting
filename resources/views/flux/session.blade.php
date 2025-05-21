<div class="w-full print:hidden mb-4 bg-white dark:bg-neutral-700 rounded p-4">
    <div class="font-semibold">{{ $slot ?? '' }} </div>
    @if (session()->has('success'))
    <div class="text-mine-200">{{ session('success') }} </div>
    @endif
    @if (session()->has('error'))
    <div class="text-rose-500">{{ session('error') }} </div>
    @endif
</div>
