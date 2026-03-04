@props(['title' => null])

@php
    $brand = config('flux-jetstream.brand', []);
    $sidebar = config('flux-jetstream.sidebar', []);
    $isDark = ($sidebar['style'] ?? 'light') === 'dark';
    $collapsedDefault = $sidebar['collapsed_default'] ?? true;
    $bodyBg = config('flux-jetstream.body_bg');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <x-favicon />

    @includeIf('layouts.partials.head')

    @if ($isDark && ($sidebar['bg'] ?? null))
        <style>:root { --fj-sidebar-bg: {{ $sidebar['bg'] }}; }</style>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    <script>
        window.Flux.applyAppearance('light');
        @if ($collapsedDefault)
            if (localStorage.getItem('flux-sidebar-collapsed-desktop') === null) {
                localStorage.setItem('flux-sidebar-collapsed-desktop', 'true');
            }
        @endif
    </script>
</head>
<body class="min-h-screen {{ $bodyBg ?: 'bg-white' }}">

    <flux:sidebar sticky collapsible
        @class([
            'dark fj-sidebar-dark' => $isDark,
            $sidebar['border'] ?? ($isDark ? 'border-r border-gray-900' : 'border-r border-zinc-200'),
            'bg-zinc-50' => ! $isDark,
        ])
    >
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div class="flex items-center gap-2">
            @if ($brand['color'] ?? null)
                <a href="{{ $brand['url'] ?? '/' }}" class="{{ $brand['color'] }} flex items-center justify-center rounded-lg size-10 shrink-0">
                    <img src="{{ $brand['logo_dark'] ?? $brand['logo'] ?? '' }}" alt="{{ $brand['name'] ?? config('app.name') }}" class="h-6 w-auto brightness-0 invert">
                </a>
            @else
                <flux:brand
                    :href="$brand['url'] ?? '/'"
                    :logo="$brand['logo'] ?? null"
                    :name="$brand['name'] ?? config('app.name')"
                    class="px-2"
                />
            @endif

            <flux:spacer />

            <flux:sidebar.collapse class="hidden lg:flex" />
        </div>

        <div class="mt-2 flex flex-col gap-1">
            @include('sidebar-navigation')
        </div>

        <flux:spacer />

        @auth
            @php $user = Auth::user(); @endphp

            <flux:dropdown position="top" align="start">
                <flux:profile
                    :name="$user->name"
                    :avatar="Laravel\Jetstream\Jetstream::managesProfilePhotos() ? $user->profile_photo_url : null"
                    :initials="! Laravel\Jetstream\Jetstream::managesProfilePhotos() ? collect(explode(' ', $user->name))->map(fn ($s) => mb_substr($s, 0, 1))->take(2)->implode('') : null"
                    :chevron="true"
                />

                <flux:menu class="w-56">
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <flux:menu.heading>{{ $user->currentTeam->name }}</flux:menu.heading>

                        <flux:menu.item href="{{ route('teams.show', $user->currentTeam->id) }}" icon="cog-6-tooth">
                            {{ __('Team Settings') }}
                        </flux:menu.item>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <flux:menu.item href="{{ route('teams.create') }}" icon="plus">
                                {{ __('Create New Team') }}
                            </flux:menu.item>
                        @endcan

                        @if ($user->allTeams()->count() > 1)
                            <flux:menu.separator />
                            <flux:menu.heading>{{ __('Switch Teams') }}</flux:menu.heading>

                            @foreach ($user->allTeams() as $team)
                                <form method="POST" action="{{ route('current-team.update') }}" x-data>
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                                    <flux:menu.item x-on:click.prevent="$root.submit()">
                                        <div class="flex items-center">
                                            @if ($user->isCurrentTeam($team))
                                                <flux:icon name="check-circle" variant="mini" class="mr-2 text-green-500" />
                                            @endif
                                            {{ $team->name }}
                                        </div>
                                    </flux:menu.item>
                                </form>
                            @endforeach
                        @endif

                        <flux:menu.separator />
                    @endif

                    <flux:menu.item href="{{ route('profile.show') }}" icon="user">
                        {{ __('Profile') }}
                    </flux:menu.item>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <flux:menu.item href="{{ route('api-tokens.index') }}" icon="key">
                            {{ __('API Tokens') }}
                        </flux:menu.item>
                    @endif

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <flux:menu.item x-on:click.prevent="$root.submit()" icon="arrow-right-start-on-rectangle">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
    </flux:sidebar>

    {{-- Mobile header --}}
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        @auth
            @php $user = Auth::user(); @endphp

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :avatar="Laravel\Jetstream\Jetstream::managesProfilePhotos() ? $user->profile_photo_url : null"
                    :initials="! Laravel\Jetstream\Jetstream::managesProfilePhotos() ? collect(explode(' ', $user->name))->map(fn ($s) => mb_substr($s, 0, 1))->take(2)->implode('') : null"
                />

                <flux:menu>
                    <flux:menu.item href="{{ route('profile.show') }}" icon="user">
                        {{ __('Profile') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <flux:menu.item x-on:click.prevent="$root.submit()" icon="arrow-right-start-on-rectangle">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
    </flux:header>

    <flux:main class="p-0! shadow-none!">
        {{ $slot }}
    </flux:main>

    @includeIf('layouts.partials.body-end')

    @fluxScripts
    <flux:toast />
</body>
</html>
