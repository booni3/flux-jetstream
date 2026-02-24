<x-layouts.app>
    <x-slot:title>{{ __('Create Team') }}</x-slot:title>

    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @livewire('teams.create-team-form')
    </div>
</x-layouts.app>
