<form wire:submit="updatePassword">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Update Password') }}</flux:heading>
            <flux:subheading>{{ __('Ensure your account is using a long, random password to stay secure.') }}</flux:subheading>
        </div>

        <flux:input label="{{ __('Current Password') }}" type="password" wire:model="state.current_password" autocomplete="current-password" />

        <flux:input label="{{ __('New Password') }}" type="password" wire:model="state.password" autocomplete="new-password" viewable />

        <flux:input label="{{ __('Confirm Password') }}" type="password" wire:model="state.password_confirmation" autocomplete="new-password" viewable />

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary" x-on:saved.window="$flux.toast('Saved.')">
                {{ __('Save') }}
            </flux:button>
        </div>
    </flux:card>
</form>
