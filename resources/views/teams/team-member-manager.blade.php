<div class="space-y-8">
    @if (Gate::check('addTeamMember', $team))
        <form wire:submit="addTeamMember">
            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Add Team Member') }}</flux:heading>
                    <flux:subheading>{{ __('Add a new team member to your team, allowing them to collaborate with you.') }}</flux:subheading>
                </div>

                <p class="text-sm text-zinc-600">
                    {{ __('Please provide the email address of the person you would like to add to this team.') }}
                </p>

                <flux:input label="{{ __('Email') }}" type="email" wire:model="addTeamMemberForm.email" />

                @if (count($this->roles) > 0)
                    <flux:field>
                        <flux:label>{{ __('Role') }}</flux:label>
                        <flux:error name="role" />

                        <flux:radio.group wire:model="addTeamMemberForm.role" variant="cards" class="mt-1">
                            @foreach ($this->roles as $index => $role)
                                <flux:radio :value="$role->key" :label="$role->name" :description="$role->description" />
                            @endforeach
                        </flux:radio.group>
                    </flux:field>
                @endif

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit" x-on:saved.window="$flux.toast('Added.')">
                        {{ __('Add') }}
                    </flux:button>
                </div>
            </flux:card>
        </form>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Pending Team Invitations') }}</flux:heading>
                <flux:subheading>{{ __('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                @foreach ($team->teamInvitations as $invitation)
                    <div class="flex items-center justify-between">
                        <div class="text-zinc-600">{{ $invitation->email }}</div>

                        @if (Gate::check('removeTeamMember', $team))
                            <flux:button variant="ghost" size="sm" wire:click="cancelTeamInvitation({{ $invitation->id }})" class="text-red-500">
                                {{ __('Cancel') }}
                            </flux:button>
                        @endif
                    </div>
                @endforeach
            </div>
        </flux:card>
    @endif

    @if ($team->users->isNotEmpty())
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Team Members') }}</flux:heading>
                <flux:subheading>{{ __('All of the people that are part of this team.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                @foreach ($team->users->sortBy('name') as $user)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                            <div class="ms-4">{{ $user->name }}</div>
                        </div>

                        <div class="flex items-center">
                            @if (Gate::check('updateTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                <button class="ms-2 text-sm text-zinc-400 underline" wire:click="manageRole('{{ $user->id }}')">
                                    {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                </button>
                            @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                <div class="ms-2 text-sm text-zinc-400">
                                    {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                </div>
                            @endif

                            @if ($this->user->id === $user->id)
                                <flux:button variant="ghost" size="sm" class="ms-6 text-red-500" wire:click="$toggle('confirmingLeavingTeam')">
                                    {{ __('Leave') }}
                                </flux:button>
                            @elseif (Gate::check('removeTeamMember', $team))
                                <flux:button variant="ghost" size="sm" class="ms-6 text-red-500" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                    {{ __('Remove') }}
                                </flux:button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </flux:card>
    @endif

    {{-- Role Management Modal --}}
    <flux:modal wire:model.self="currentlyManagingRole" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">{{ __('Manage Role') }}</flux:heading>

            <flux:radio.group wire:model="currentRole" variant="cards">
                @foreach ($this->roles as $index => $role)
                    <flux:radio :value="$role->key" :label="$role->name" :description="$role->description" />
                @endforeach
            </flux:radio.group>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="stopManagingRole" wire:loading.attr="disabled">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" wire:click="updateRole" wire:loading.attr="disabled">{{ __('Save') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Leave Team Confirmation Modal --}}
    <flux:modal wire:model.self="confirmingLeavingTeam" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Leave Team') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Are you sure you would like to leave this team?') }}</flux:subheading>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="leaveTeam" wire:loading.attr="disabled">{{ __('Leave') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Remove Team Member Confirmation Modal --}}
    <flux:modal wire:model.self="confirmingTeamMemberRemoval" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Remove Team Member') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Are you sure you would like to remove this person from the team?') }}</flux:subheading>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="removeTeamMember" wire:loading.attr="disabled">{{ __('Remove') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
