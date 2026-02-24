<x-layouts.app>
    <x-slot:title>{{ __('API Tokens') }}</x-slot:title>

    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @livewire('api.api-token-manager')
    </div>
</x-layouts.app>
