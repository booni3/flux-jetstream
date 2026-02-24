<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('Two Factor Authentication') }}</flux:heading>
        <flux:subheading>{{ __('Add additional security to your account using two factor authentication.') }}</flux:subheading>
    </div>

    <h3 class="text-lg font-medium text-zinc-900">
        @if ($this->enabled)
            @if ($showingConfirmation)
                {{ __('Finish enabling two factor authentication.') }}
            @else
                {{ __('You have enabled two factor authentication.') }}
            @endif
        @else
            {{ __('You have not enabled two factor authentication.') }}
        @endif
    </h3>

    <p class="text-sm text-zinc-600">
        {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
    </p>

    @if ($this->enabled)
        @if ($showingQrCode)
            <p class="text-sm font-semibold text-zinc-600">
                @if ($showingConfirmation)
                    {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                @else
                    {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                @endif
            </p>

            <div class="p-2 inline-block bg-white">
                {!! $this->user->twoFactorQrCodeSvg() !!}
            </div>

            <p class="text-sm font-semibold text-zinc-600">
                {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
            </p>

            @if ($showingConfirmation)
                <flux:input label="{{ __('Code') }}" type="text" inputmode="numeric" autofocus autocomplete="one-time-code" wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" class="!w-1/2" />
            @endif
        @endif

        @if ($showingRecoveryCodes)
            <p class="text-sm font-semibold text-zinc-600">
                {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
            </p>

            <div class="grid gap-1 max-w-xl px-4 py-4 font-mono text-sm bg-zinc-100 rounded-lg">
                @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                    <div>{{ $code }}</div>
                @endforeach
            </div>
        @endif
    @endif

    <div class="flex gap-3">
        @if (! $this->enabled)
            <x-confirms-password wire:then="enableTwoFactorAuthentication">
                <flux:button variant="primary" type="button" wire:loading.attr="disabled">
                    {{ __('Enable') }}
                </flux:button>
            </x-confirms-password>
        @else
            @if ($showingRecoveryCodes)
                <x-confirms-password wire:then="regenerateRecoveryCodes">
                    <flux:button variant="ghost" type="button">
                        {{ __('Regenerate Recovery Codes') }}
                    </flux:button>
                </x-confirms-password>
            @elseif ($showingConfirmation)
                <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                    <flux:button variant="primary" type="button" wire:loading.attr="disabled">
                        {{ __('Confirm') }}
                    </flux:button>
                </x-confirms-password>
            @else
                <x-confirms-password wire:then="showRecoveryCodes">
                    <flux:button variant="ghost" type="button">
                        {{ __('Show Recovery Codes') }}
                    </flux:button>
                </x-confirms-password>
            @endif

            @if ($showingConfirmation)
                <x-confirms-password wire:then="disableTwoFactorAuthentication">
                    <flux:button variant="ghost" type="button" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </flux:button>
                </x-confirms-password>
            @else
                <x-confirms-password wire:then="disableTwoFactorAuthentication">
                    <flux:button variant="danger" type="button" wire:loading.attr="disabled">
                        {{ __('Disable') }}
                    </flux:button>
                </x-confirms-password>
            @endif
        @endif
    </div>
</flux:card>
