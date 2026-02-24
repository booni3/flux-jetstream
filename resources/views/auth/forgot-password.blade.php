<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md space-y-6">
            <flux:subheading>
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </flux:subheading>

            @session('status')
                <div class="font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <flux:input label="{{ __('Email') }}" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">
                        {{ __('Email Password Reset Link') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-guest-layout>
