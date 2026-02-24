# Flux Jetstream

Drop-in [Flux UI v2](https://fluxui.dev) replacements for all of [Laravel Jetstream](https://jetstream.laravel.com)'s published Blade views (Livewire stack).

Replaces Jetstream's default Blade components (`<x-input>`, `<x-button>`, `<x-form-section>`, `<x-dialog-modal>`, etc.) with their Flux UI equivalents (`<flux:input>`, `<flux:button>`, `<flux:card>`, `<flux:modal>`, etc.).

## Requirements

- PHP 8.2+
- Laravel 11 or 12
- Jetstream 5+ (Livewire stack)
- Flux UI 2.0+

## What the Package Provides

### Auth pages (standalone, use the guest layout)

| View | Description |
|---|---|
| `auth/login.blade.php` | Email/password login with remember me |
| `auth/register.blade.php` | Registration with optional terms checkbox |
| `auth/forgot-password.blade.php` | Password reset request |
| `auth/reset-password.blade.php` | Password reset form |
| `auth/confirm-password.blade.php` | Password confirmation gate |
| `auth/verify-email.blade.php` | Email verification notice |
| `auth/two-factor-challenge.blade.php` | 2FA with `<flux:otp>` and recovery code fallback |

### Settings panels (wrapped in your app's authenticated layout)

| View | Description |
|---|---|
| `profile/show.blade.php` | Profile settings container (includes sub-forms based on enabled Jetstream/Fortify features) |
| `profile/update-profile-information-form.blade.php` | Name, email, photo upload |
| `profile/update-password-form.blade.php` | Current/new/confirm password |
| `profile/two-factor-authentication-form.blade.php` | Enable/disable 2FA, QR code, recovery codes |
| `profile/logout-other-browser-sessions-form.blade.php` | Session management with confirmation modal |
| `profile/delete-user-form.blade.php` | Account deletion with confirmation modal |
| `teams/create.blade.php` | Team creation container |
| `teams/show.blade.php` | Team settings container |
| `teams/create-team-form.blade.php` | Team name input with owner display |
| `teams/update-team-name-form.blade.php` | Update team name (disabled for non-owners) |
| `teams/team-member-manager.blade.php` | Add members, manage roles, pending invitations, remove/leave modals |
| `teams/delete-team-form.blade.php` | Team deletion with confirmation modal |
| `api/index.blade.php` | API tokens container |
| `api/api-token-manager.blade.php` | Create/edit/delete tokens with permission checkboxes |

### Layouts and components

| View | Description |
|---|---|
| `layouts/guest.blade.php` | Minimal HTML shell for auth pages (loads Vite, Livewire, Flux) |
| `components/confirms-password.blade.php` | Password confirmation modal using Flux (same external API as Jetstream's) |
| `terms.blade.php` | Terms of service page |
| `policy.blade.php` | Privacy policy page |

### What the package does NOT provide

- **Your authenticated layout** (`components/layouts/app.blade.php`) — the settings pages reference `<x-layouts.app>` as their wrapper, but each app provides its own sidebar/topbar/navigation layout.
- **Your application logo** (`<x-application-logo>`) — each app provides its own branding component.
- **Your favicon** (`<x-favicon>`) — each app provides its own favicon links.
- **The `GuestLayout` class component** — each app keeps this at `app/View/Components/GuestLayout.php` (already exists from Jetstream install).
- **Your dashboard or any other app-specific pages.**

## How It Works

The package registers its views directory as a **fallback location** in Laravel's view finder using `View::addLocation()`. This means:

1. If a view exists in your app's `resources/views/`, Laravel uses that.
2. If it doesn't exist in the app, Laravel falls back to the package's views.

Jetstream's Livewire components call views without a namespace (e.g. `view('profile.update-password-form')`), so `addLocation()` is the correct approach — the package's views slot in exactly where Jetstream expects them.

## Installation

### 1. Require the package

```bash
composer require profilestudio/flux-jetstream
```

The service provider is auto-discovered — no manual registration needed.

### 2. Delete Jetstream's published views

Remove the views that the package now provides:

```bash
# Auth views
rm -rf resources/views/auth/

# Profile views
rm -rf resources/views/profile/

# Team views
rm -rf resources/views/teams/

# API views
rm -rf resources/views/api/

# Guest layout, confirms-password, terms, policy
rm resources/views/layouts/guest.blade.php
rm resources/views/components/confirms-password.blade.php
rm -f resources/views/terms.blade.php
rm -f resources/views/policy.blade.php
```

Also delete the old Jetstream Blade components that Flux replaces:

```bash
# Old Jetstream components (no longer needed)
rm -f resources/views/components/button.blade.php
rm -f resources/views/components/secondary-button.blade.php
rm -f resources/views/components/danger-button.blade.php
rm -f resources/views/components/input.blade.php
rm -f resources/views/components/label.blade.php
rm -f resources/views/components/checkbox.blade.php
rm -f resources/views/components/input-error.blade.php
rm -f resources/views/components/validation-errors.blade.php
rm -f resources/views/components/form-section.blade.php
rm -f resources/views/components/action-section.blade.php
rm -f resources/views/components/section-title.blade.php
rm -f resources/views/components/section-border.blade.php
rm -f resources/views/components/modal.blade.php
rm -f resources/views/components/dialog-modal.blade.php
rm -f resources/views/components/confirmation-modal.blade.php
rm -f resources/views/components/authentication-card.blade.php
rm -f resources/views/components/authentication-card-logo.blade.php
rm -f resources/views/components/action-message.blade.php
rm -f resources/views/components/banner.blade.php
rm -f resources/views/components/welcome.blade.php
```

And delete the dead `AppLayout` class (its view `layouts/app.blade.php` is the old Jetstream layout, not your sidebar layout):

```bash
rm -f app/View/Components/AppLayout.php
```

### 3. Clear the view cache

```bash
php artisan view:clear
```

## What Your App Must Provide

The package views expect these components to exist in your app:

### 1. Authenticated layout — `resources/views/components/layouts/app.blade.php`

Your main application layout with navigation, topbar, user menu, etc. The settings pages wrap themselves in it like this:

```blade
<x-layouts.app>
    <x-slot:title>Profile</x-slot:title>
    <!-- settings content -->
</x-layouts.app>
```

Your layout should render `{{ $title ?? '' }}` in the header area and `{{ $slot }}` for page content.

### 2. Application logo — `resources/views/components/application-logo.blade.php`

Displayed on auth pages (login, register, etc.) and terms/policy pages. Receives a `class` attribute for sizing:

```blade
{{-- Example: resources/views/components/application-logo.blade.php --}}
<svg {{ $attributes }} viewBox="0 0 100 100">
    <!-- your logo SVG -->
</svg>
```

### 3. Favicon — `resources/views/components/favicon.blade.php`

Included in the guest layout's `<head>`. Should output your favicon `<link>` tags:

```blade
{{-- Example: resources/views/components/favicon.blade.php --}}
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
```

### 4. GuestLayout class — `app/View/Components/GuestLayout.php`

This already exists from the standard Jetstream install. It maps `<x-guest-layout>` to `view('layouts.guest')` — the view file itself comes from this package:

```php
<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public function render(): View
    {
        return view('layouts.guest');
    }
}
```

### 5. Vite entry points

The guest layout calls `@vite(['resources/css/app.css', 'resources/js/app.js'])`. Ensure your Vite config builds these and that Tailwind/Flux styles are included.

## Overriding Views

To customise a specific view, place a file at the matching path in your app's `resources/views/`. For example, to override the login page:

```
resources/views/auth/login.blade.php
```

Your app's version takes precedence automatically — no configuration needed.

## Component Mapping

Reference for what was replaced:

| Jetstream Component | Flux Replacement |
|---|---|
| `<x-label>` + `<x-input>` | `<flux:input label="..." />` |
| `<x-input type="password">` | `<flux:input type="password" viewable />` |
| `<x-checkbox>` | `<flux:checkbox />` |
| `<x-button>` | `<flux:button variant="primary">` |
| `<x-secondary-button>` | `<flux:button variant="ghost">` |
| `<x-danger-button>` | `<flux:button variant="danger">` |
| `<x-input-error>` | Automatic via `<flux:input>` or `<flux:error>` |
| `<x-form-section>` | `<flux:card>` with `<flux:heading>` + `<flux:subheading>` |
| `<x-action-section>` | `<flux:card>` with heading/subheading |
| `<x-section-border>` | `<flux:separator />` |
| `<x-dialog-modal>` | `<flux:modal>` |
| `<x-confirmation-modal>` | `<flux:modal>` with danger pattern |
| `<x-action-message on="saved">` | `x-on:saved.window="$flux.toast('Saved.')"` |
| `<x-authentication-card>` | Centered `<flux:card class="w-full sm:max-w-md">` |
| Links (`<a class="underline...">`) | `<flux:link>` |

## License

MIT. See [LICENSE](LICENSE).
