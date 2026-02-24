<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('Browser Sessions') }}</flux:heading>
        <flux:subheading>{{ __('Manage and log out your active sessions on other browsers and devices.') }}</flux:subheading>
    </div>

    <p class="text-sm text-zinc-600">
        {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
    </p>

    @if (count($this->sessions) > 0)
        <div class="space-y-4">
            @foreach ($this->sessions as $session)
                <div class="flex items-center">
                    <div>
                        @if ($session->agent->isDesktop())
                            <flux:icon.computer-desktop class="w-8 h-8 text-zinc-500" />
                        @else
                            <flux:icon.device-phone-mobile class="w-8 h-8 text-zinc-500" />
                        @endif
                    </div>

                    <div class="ms-3">
                        <div class="text-sm text-zinc-600">
                            {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                        </div>

                        <div class="text-xs text-zinc-500">
                            {{ $session->ip_address }},

                            @if ($session->is_current_device)
                                <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                            @else
                                {{ __('Last active') }} {{ $session->last_active }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex items-center gap-3">
        <flux:button variant="primary" wire:click="confirmLogout" wire:loading.attr="disabled">
            {{ __('Log Out Other Browser Sessions') }}
        </flux:button>
    </div>

    <flux:modal wire:model.self="confirmingLogout" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Log Out Other Browser Sessions') }}</flux:heading>
                <flux:subheading class="mt-2">{{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}</flux:subheading>
            </div>

            <div x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                <flux:input type="password" wire:model="password" label="{{ __('Password') }}" x-ref="password" wire:keydown.enter="logoutOtherBrowserSessions" />
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="$toggle('confirmingLogout')">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled" x-on:logged-out.window="$flux.toast('Done.')">{{ __('Log Out Other Browser Sessions') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</flux:card>
