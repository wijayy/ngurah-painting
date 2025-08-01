@php
extract(flux::forwardedattributes($attributes, [
    'name',
    'description',
    'label',
]));
@endphp

@props([
    'name' => $attributes->whereStartsWith('wire:model.live')->first(),
    'description' => null,
    'label' => null,
])

<?php if ($label || $description): ?>
    <flux:field variant="inline">
        <?php if ($label): ?>
            <flux:label>{{ $label }}</flux:label>
        <?php endif; ?>

        <?php if ($description): ?>
            <flux:description>{{ $description }}</flux:description>
        <?php endif; ?>

        {{ $slot }}

        <flux:error :$name />
    </flux:field>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>

