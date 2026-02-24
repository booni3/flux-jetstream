<form wire:submit="updateProfileInformation">
    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Profile Information') }}</flux:heading>
            <flux:subheading>{{ __('Update your account\'s profile information and email address.') }}</flux:subheading>
        </div>

        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}">
                <input type="file" id="photo" class="hidden"
                    wire:model.live="photo"
                    x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <flux:field>
                    <flux:label>{{ __('Photo') }}</flux:label>

                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                    </div>

                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <div class="flex gap-2 mt-2">
                        <flux:button variant="ghost" size="sm" type="button" x-on:click.prevent="$refs.photo.click()">
                            {{ __('Select A New Photo') }}
                        </flux:button>

                        @if ($this->user->profile_photo_path)
                            <flux:button variant="ghost" size="sm" type="button" wire:click="deleteProfilePhoto">
                                {{ __('Remove Photo') }}
                            </flux:button>
                        @endif
                    </div>

                    <flux:error name="photo" />
                </flux:field>
            </div>
        @endif

        <flux:input label="{{ __('Name') }}" type="text" wire:model="state.name" required autocomplete="name" />

        <div>
            <flux:input label="{{ __('Email') }}" type="email" wire:model="state.email" required autocomplete="username" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-zinc-600 hover:text-zinc-900" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="photo" x-on:saved.window="$flux.toast('Saved.')">
                {{ __('Save') }}
            </flux:button>
        </div>
    </flux:card>
</form>
