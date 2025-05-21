@php
extract(Flux::forwardedAttributes($attributes, ['name', 'multiple', 'size']));
@endphp

@props([
'name' => $attributes->whereStartsWith('wire:model')->first(),
'multiple' => null,
'size' => null,
'preview' => null,
'label' => null,
])

@php
$classes = Flux::classes()->add('w-full flex items-center gap-4 space-y-4')->add('relative');

$nameAttr = $attributes->whereStartsWith('wire:model')->first();
$oldImageName = $nameAttr ? "old_{$nameAttr}" : 'old_image';

[$styleAttributes, $attributes] = Flux::splitAttributes($attributes);

// Cek jika preview disediakan (berasal dari nilai lama image pada wire:model)
$defaultPreview = $preview ? asset('storage/' . $preview) : '';
@endphp

<div {{ $styleAttributes->class($classes) }} data-flux-input-file wire:ignore tabindex="0" x-data="{
    previewUrl: '{{ $defaultPreview }}',
    hasInitial: '{{ $defaultPreview }}' !== '',
    showHiddenInput: '{{ $defaultPreview }}' !== '',
    clearImage() {
    this.previewUrl = null;
    this.hasInitial = false;
    this.showHiddenInput = false;
    this.$refs.input.value = '';
    this.$refs.old_image.value = '';
    this.$refs.name.textContent = '{{ __('No file chosen') }}';
    },
    updatePreview(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
    this.previewUrl = URL.createObjectURL(file);
    this.hasInitial = false;
    this.$refs.old_image.value = '';
    this.showHiddenInput = false;
    } else {
    this.previewUrl = null;
    }

    this.$refs.name.textContent = event.target.files[1] ?
    (event.target.files.length + ' {{ __('files') }}') :
    (event.target.files[0]?.name || '{{ __('No file chosen') }}');
    }
    }"
    x-on:click.prevent.stop="$refs.input.click()" x-on:keyup.space.prevent.stop="$refs.input.click()">

    {{-- INPUT FILE --}}
    <input x-ref="input" x-on:click.stop x-init="Object.defineProperty($el, 'value', {
        ...Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value'),
        set(value) {
            Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value').set.call(this, value);
            if (!value) this.dispatchEvent(new Event('change', { bubbles: true }))
        }
    })" x-on:change="updatePreview($event)" type="file" class="sr-only" tabindex="-1" {{ $attributes }} {{ $multiple
        ? 'multiple' : '' }} @if ($name) name="{{ $name }}" @endif>

    {{-- PREVIEW IMAGE --}}
    <div class="aspect-square border rounded  relative flex items-center bg-white dark:bg-zinc-700 w-full bg-cover bg-no-repeat bg-center"
        :style="'background-image: url(' + previewUrl + ')'">
        <div x-cloak x-show="!previewUrl" class="w-full text-xs font-semibold text-center">No file chosen</div>

    </div>
    <div class="">
        <flux:label>{{ $label }} </flux:label>
        {{-- BUTTON --}}
        <flux:button as="div" class="cursor-pointer" :$size aria-hidden="true">
            {!! $multiple ? __('Choose files') : __('Choose file') !!}
        </flux:button>
    </div>

    {{-- HIDDEN INPUT UNTUK IMAGE LAMA --}}
    <flux:input type="hidden" x-ref="old_image" wire:model="{{ $oldImageName }}" />

</div>
