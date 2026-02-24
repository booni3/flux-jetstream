<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md space-y-6">
            <flux:subheading>
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </flux:subheading>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <flux:input label="{{ __('Password') }}" type="password" name="password" required autocomplete="current-password" autofocus />

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">
                        {{ __('Confirm') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-guest-layout>
