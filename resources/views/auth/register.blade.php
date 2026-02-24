<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md space-y-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <flux:input label="{{ __('Name') }}" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

                <flux:input label="{{ __('Email') }}" type="email" name="email" :value="old('email')" required autocomplete="username" />

                <flux:input label="{{ __('Password') }}" type="password" name="password" required autocomplete="new-password" viewable />

                <flux:input label="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required autocomplete="new-password" viewable />

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <flux:checkbox name="terms" required>
                        <flux:checkbox.label>
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<flux:link href="'.route('terms.show').'" target="_blank">'.__('Terms of Service').'</flux:link>',
                                'privacy_policy' => '<flux:link href="'.route('policy.show').'" target="_blank">'.__('Privacy Policy').'</flux:link>',
                            ]) !!}
                        </flux:checkbox.label>
                    </flux:checkbox>
                @endif

                <div class="flex items-center justify-between">
                    <flux:link href="{{ route('login') }}" variant="subtle" class="text-sm">
                        {{ __('Already registered?') }}
                    </flux:link>

                    <flux:button variant="primary" type="submit">
                        {{ __('Register') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-guest-layout>
