<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md">
            <div x-data="{ recovery: false }">
                <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-8">
                    @csrf

                    <div x-show="! recovery" class="space-y-8">
                        <div class="max-w-64 mx-auto space-y-2">
                            <flux:heading size="lg" class="text-center">{{ __('Two Factor Authentication') }}</flux:heading>
                            <flux:text class="text-center">{{ __('Please enter the authentication code from your authenticator application.') }}</flux:text>
                        </div>

                        <flux:otp name="code" length="6" label="{{ __('Code') }}" label:sr-only :error:icon="false" error:class="text-center" class="mx-auto" autofocus x-ref="code" autocomplete="one-time-code" />

                        <div class="space-y-4">
                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
                            <flux:button variant="ghost" type="button" class="w-full"
                                x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                                {{ __('Use a recovery code') }}
                            </flux:button>
                        </div>
                    </div>

                    <div x-cloak x-show="recovery" class="space-y-8">
                        <div class="max-w-64 mx-auto space-y-2">
                            <flux:heading size="lg" class="text-center">{{ __('Recovery Code') }}</flux:heading>
                            <flux:text class="text-center">{{ __('Please enter one of your emergency recovery codes.') }}</flux:text>
                        </div>

                        <flux:input name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />

                        <div class="space-y-4">
                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
                            <flux:button variant="ghost" type="button" class="w-full"
                                x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                                {{ __('Use an authentication code') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </flux:card>
    </div>
</x-guest-layout>
