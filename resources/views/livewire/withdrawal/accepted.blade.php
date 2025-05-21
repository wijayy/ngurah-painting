<div>
    <flux:session>Accept The Driver Demands</flux:session>

    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        <form wire:submit.prevent='save' class="bg-white dark:bg-neutral-700 p-4">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <flux:input.file wire:model='image' label="Proof of Withdrawal"></flux:input.file>
            </div>
            <flux:input wire:model='amount' label="Withdrawal Amount" required></flux:input>
            <flux:button type="submit" variant="primary" class="mt-4">Submit</flux:button>
        </form>
    </div>
</div>
