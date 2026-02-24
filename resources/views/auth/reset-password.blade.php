<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md space-y-6">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <flux:input label="{{ __('Email') }}" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />

                <flux:input label="{{ __('Password') }}" type="password" name="password" required autocomplete="new-password" viewable />

                <flux:input label="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required autocomplete="new-password" viewable />

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">
                        {{ __('Reset Password') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-guest-layout>
