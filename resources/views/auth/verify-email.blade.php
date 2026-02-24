<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50">
        <div class="mb-6">
            <x-application-logo class="h-12 w-auto" />
        </div>
        <flux:card class="w-full sm:max-w-md space-y-6">
            <flux:subheading>
                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </flux:subheading>

            @if (session('status') == 'verification-link-sent')
                <div class="font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <flux:button variant="primary" type="submit">
                        {{ __('Resend Verification Email') }}
                    </flux:button>
                </form>

                <div class="flex items-center gap-3">
                    <flux:link href="{{ route('profile.show') }}" variant="subtle" class="text-sm">
                        {{ __('Edit Profile') }}
                    </flux:link>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <flux:button variant="ghost" type="submit" size="sm">
                            {{ __('Log Out') }}
                        </flux:button>
                    </form>
                </div>
            </div>
        </flux:card>
    </div>
</x-guest-layout>
