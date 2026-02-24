<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md space-y-6">
            @session('status')
                <div class="font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <flux:input label="{{ __('Email') }}" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />

                <flux:input label="{{ __('Password') }}" type="password" name="password" required autocomplete="current-password" />

                <div class="flex items-center justify-between">
                    <flux:checkbox label="{{ __('Remember me') }}" name="remember" />

                    @if (Route::has('password.request'))
                        <flux:link href="{{ route('password.request') }}" variant="subtle" class="text-sm">
                            {{ __('Forgot your password?') }}
                        </flux:link>
                    @endif
                </div>

                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Log in') }}
                </flux:button>
            </form>
        </flux:card>
    </div>
</x-guest-layout>
