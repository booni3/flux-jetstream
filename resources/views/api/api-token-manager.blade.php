<div class="space-y-8">
    <form wire:submit="createApiToken">
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Create API Token') }}</flux:heading>
                <flux:subheading>{{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}</flux:subheading>
            </div>

            <flux:input label="{{ __('Token Name') }}" type="text" wire:model="createApiTokenForm.name" autofocus />

            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                <flux:field>
                    <flux:label>{{ __('Permissions') }}</flux:label>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                            <flux:checkbox wire:model="createApiTokenForm.permissions" :value="$permission" :label="$permission" />
                        @endforeach
                    </div>
                </flux:field>
            @endif

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit" x-on:created.window="$flux.toast('Created.')">
                    {{ __('Create') }}
                </flux:button>
            </div>
        </flux:card>
    </form>

    @if ($this->user->tokens->isNotEmpty())
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Manage API Tokens') }}</flux:heading>
                <flux:subheading>{{ __('You may delete any of your existing tokens if they are no longer needed.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                @foreach ($this->user->tokens->sortBy('name') as $token)
                    <div class="flex items-center justify-between">
                        <div class="break-all">
                            {{ $token->name }}
                        </div>

                        <div class="flex items-center ms-2">
                            @if ($token->last_used_at)
                                <div class="text-sm text-zinc-400">
                                    {{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}
                                </div>
                            @endif

                            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                <button class="cursor-pointer ms-6 text-sm text-zinc-400 underline" wire:click="manageApiTokenPermissions({{ $token->id }})">
                                    {{ __('Permissions') }}
                                </button>
                            @endif

                            <button class="cursor-pointer ms-6 text-sm text-red-500" wire:click="confirmApiTokenDeletion({{ $token->id }})">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </flux:card>
    @endif

    {{-- Token Value Modal --}}
    <flux:modal wire:model.self="displayingToken" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('API Token') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}</flux:subheading>
            </div>

            <div x-data="{}" x-on:showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)">
                <flux:input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken" class="font-mono text-sm" />
            </div>

            <div class="flex justify-end">
                <flux:button variant="ghost" wire:click="$set('displayingToken', false)">{{ __('Close') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- API Token Permissions Modal --}}
    <flux:modal wire:model.self="managingApiTokenPermissions" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">{{ __('API Token Permissions') }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <flux:checkbox wire:model="updateApiTokenForm.permissions" :value="$permission" :label="$permission" />
                @endforeach
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" wire:click="updateApiToken" wire:loading.attr="disabled">{{ __('Save') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Delete Token Confirmation Modal --}}
    <flux:modal wire:model.self="confirmingApiTokenDeletion" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete API Token') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Are you sure you would like to delete this API token?') }}</flux:subheading>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteApiToken" wire:loading.attr="disabled">{{ __('Delete') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
