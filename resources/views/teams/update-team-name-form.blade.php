<form wire:submit="updateTeamName">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Team Name') }}</flux:heading>
            <flux:subheading>{{ __('The team\'s name and owner information.') }}</flux:subheading>
        </div>

        <flux:field>
            <flux:label>{{ __('Team Owner') }}</flux:label>
            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">
                <div class="ms-4 leading-tight">
                    <div class="text-zinc-900">{{ $team->owner->name }}</div>
                    <div class="text-zinc-700 text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </flux:field>

        <flux:input label="{{ __('Team Name') }}" type="text" wire:model="state.name" :disabled="! Gate::check('update', $team)" />

        @if (Gate::check('update', $team))
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" x-on:saved.window="$flux.toast('Saved.')">
                    {{ __('Save') }}
                </flux:button>
            </div>
        @endif
    </flux:card>
</form>
