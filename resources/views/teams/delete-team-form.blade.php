<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('Delete Team') }}</flux:heading>
        <flux:subheading>{{ __('Permanently delete this team.') }}</flux:subheading>
    </div>

    <p class="text-sm text-zinc-600">
        {{ __('Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.') }}
    </p>

    <div>
        <flux:button variant="danger" wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
            {{ __('Delete Team') }}
        </flux:button>
    </div>

    <flux:modal wire:model.self="confirmingTeamDeletion" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete Team') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.') }}</flux:subheading>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteTeam" wire:loading.attr="disabled">{{ __('Delete Team') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</flux:card>
