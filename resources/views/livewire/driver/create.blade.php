<div>
    <flux:session>Add Driver</flux:session>
    <form wire:submit.prevent='save' class="rounded bg-white dark:bg-neutral-700 p-4">
        <div class="grid grid-cols-1 gap-4 mb-4 md:mb-8 md:grid-cols-6">
            <div class="md:col-span-2">
                <flux:input class="" wire:model='name' label="Driver Name" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model='email' label="Email Address" required></flux:input>
            </div>
            <div class="md:col-span-2">
                <flux:input class="" wire:model='phone' placeholder="62XXXXXXXXXXX" label="Phone Number" required></flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model='password' label="Password" required>
                </flux:input>
            </div>
            <div class="md:col-span-3">
                <flux:input type="password" viewable class="" wire:model='password_confirmation' label="Confirm Password"
                    required></flux:input>
            </div>
        </div>
        <flux:button type="submit" variant="primary">Submit</flux:button>
    </form>
</div>
