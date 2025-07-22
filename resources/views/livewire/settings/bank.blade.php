<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public $bank = '';
    public $account_number = '';
    public $account_name = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->bank = Auth::user()->driver?->bank;
        $this->account_number = Auth::user()->driver?->account_number;
        $this->account_name = Auth::user()->driver?->account_name;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateBankInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'bank' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        $user->driver->update($validated);

        $this->dispatch('bank-updated');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Bank Account')" :subheading="__('Bank Information for Withdrawal Purposes')">
        <form wire:submit="updateBankInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model.live="bank" :label="__('Bank')" type="text" required autofocus autocomplete="bank" />
            <flux:input wire:model.live="account_number" :label="__('Account Number')" type="text" required
                autocomplete="account_number" />
            <flux:input wire:model.live="account_name" :label="__('Account Name')" type="text" required
                autocomplete="account_name" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="bank-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
