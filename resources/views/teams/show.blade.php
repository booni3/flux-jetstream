<x-layouts.app>
    <x-slot:title>{{ __('Team Settings') }}</x-slot:title>

    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">
        @livewire('teams.update-team-name-form', ['team' => $team])

        @livewire('teams.team-member-manager', ['team' => $team])

        @if (Gate::check('delete', $team) && ! $team->personal_team)
            @livewire('teams.delete-team-form', ['team' => $team])
        @endif
    </div>
</x-layouts.app>
