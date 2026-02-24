<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('Delete Account') }}</flux:heading>
        <flux:subheading>{{ __('Permanently delete your account.') }}</flux:subheading>
    </div>

    <p class="text-sm text-zinc-600">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>

    <div>
        <flux:button variant="danger" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
            {{ __('Delete Account') }}
        </flux:button>
    </div>

    <flux:modal wire:model.self="confirmingUserDeletion" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete Account') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</flux:subheading>
            </div>

            <div x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <flux:input type="password" wire:model="password" label="{{ __('Password') }}" placeholder="{{ __('Password') }}" x-ref="password" wire:keydown.enter="deleteUser" />
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$toggle('confirmingUserDeletion')">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteUser" wire:loading.attr="disabled">{{ __('Delete Account') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</flux:card>
