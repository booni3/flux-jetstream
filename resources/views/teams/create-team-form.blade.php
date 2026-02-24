<form wire:submit="createTeam">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Team Details') }}</flux:heading>
            <flux:subheading>{{ __('Create a new team to collaborate with others on projects.') }}</flux:subheading>
        </div>

        <flux:field>
            <flux:label>{{ __('Team Owner') }}</flux:label>
            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">
                <div class="ms-4 leading-tight">
                    <div class="text-zinc-900">{{ $this->user->name }}</div>
                    <div class="text-zinc-700 text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </flux:field>

        <flux:input label="{{ __('Team Name') }}" type="text" wire:model="state.name" autofocus />

        <div class="flex justify-end">
            <flux:button variant="primary" type="submit">
                {{ __('Create') }}
            </flux:button>
        </div>
    </flux:card>
</form>
