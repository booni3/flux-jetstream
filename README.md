# Flux Jetstream

Drop-in [Flux UI v2](https://fluxui.dev) replacements for all of [Laravel Jetstream](https://jetstream.laravel.com)'s published Blade views (Livewire stack), plus an optional Flux sidebar layout.

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

### Settings panels (wrapped in the authenticated layout)

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
| `components/layouts/app.blade.php` | Flux sidebar layout with stashable sidebar, profile dropdown, team switching, and mobile header |
| `layouts/guest.blade.php` | Minimal HTML shell for auth pages (loads Vite, Livewire, Flux) |
| `components/confirms-password.blade.php` | Password confirmation modal using Flux (same external API as Jetstream's) |
| `terms.blade.php` | Terms of service page |
| `policy.blade.php` | Privacy policy page |

## How It Works

The package registers its views directory as a **fallback location** in Laravel's view finder using `View::addLocation()`. This means:

1. If a view exists in your app's `resources/views/`, Laravel uses that.
2. If it doesn't exist in the app, Laravel falls back to the package's views.

Jetstream's Livewire components call views without a namespace (e.g. `view('profile.update-password-form')`), so `addLocation()` is the correct approach — the package's views slot in exactly where Jetstream expects them.

## Installation

### 1. Require the package

```bash
composer require booni3/flux-jetstream
```

The service provider is auto-discovered — no manual registration needed.

### 2. Publish the config

```bash
php artisan vendor:publish --tag=flux-jetstream-config
```

Edit `config/flux-jetstream.php` to set your brand name and logo:

```php
return [
    'brand' => [
        'name' => 'My App',
        'logo' => '/img/logo.png',      // path to logo image
        'logo_dark' => null,             // optional dark mode variant
        'url' => '/',                    // logo link target
    ],
];
```

### 3. Create required app views

#### Sidebar navigation — `resources/views/sidebar-navigation.blade.php`

The authenticated layout includes this view inside a `<flux:navlist>`. Add your navigation items:

```blade
<flux:navlist.item icon="home" href="/" :current="request()->routeIs('dashboard')">
    Dashboard
</flux:navlist.item>
<flux:navlist.item icon="inbox" href="/orders" :current="request()->routeIs('orders.*')">
    Orders
</flux:navlist.item>
```

#### Favicon — `resources/views/components/favicon.blade.php`

Included in both the guest and authenticated layout's `<head>`:

```blade
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
```

#### Application logo — `resources/views/components/application-logo.blade.php`

Displayed on auth pages (login, register, etc.). Receives a `class` attribute for sizing:

```blade
<svg {{ $attributes }} viewBox="0 0 100 100">
    <!-- your logo SVG -->
</svg>
```

### 4. Optional app views

#### Head partial — `resources/views/layouts/partials/head.blade.php`

Extra `<head>` content (fonts, meta tags, etc.):

```blade
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
```

#### Body-end partial — `resources/views/layouts/partials/body-end.blade.php`

Scripts, modals, or other content before `</body>`:

```blade
@livewire('modal-pro')
<script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
```

### 5. Delete Jetstream's published views

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

# Layouts and components now provided by package
rm -f resources/views/layouts/guest.blade.php
rm -f resources/views/layouts/app.blade.php
rm -f resources/views/components/layouts/app.blade.php
rm -f resources/views/components/confirms-password.blade.php
rm -f resources/views/terms.blade.php
rm -f resources/views/policy.blade.php
```

Also delete the old Jetstream Blade components that Flux replaces:

```bash
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
rm -f resources/views/components/welcome.blade.php
```

And delete the dead layout infrastructure:

```bash
rm -f app/View/Components/AppLayout.php
rm -f resources/views/navigation-menu.blade.php
rm -f resources/views/components/switchable-team.blade.php
rm -f resources/views/components/dropdown.blade.php
rm -f resources/views/components/dropdown-link.blade.php
rm -f resources/views/components/nav-link.blade.php
rm -f resources/views/components/responsive-nav-link.blade.php
rm -f resources/views/components/banner.blade.php
```

### 6. Add Tailwind content source

Tailwind v4 does not scan `vendor/` by default. Add a `@source` directive to your `resources/css/app.css`:

```css
@source "../../vendor/booni3/flux-jetstream/resources/views";
```

Then rebuild your assets:

```bash
npm run build
```

### 7. Clear the view cache

```bash
php artisan view:clear
```

## What Your App Must Provide (Summary)

| File | Required | Description |
|---|---|---|
| `components/application-logo.blade.php` | Yes | Logo for auth pages |
| `components/favicon.blade.php` | Yes | Favicon `<link>` tags |
| `sidebar-navigation.blade.php` | Yes | `<flux:navlist.item>` entries |
| `app/View/Components/GuestLayout.php` | Yes | Already exists from Jetstream install |
| `layouts/partials/head.blade.php` | No | Extra `<head>` content |
| `layouts/partials/body-end.blade.php` | No | Scripts/modals before `</body>` |

## Overriding Views

To customise a specific view, place a file at the matching path in your app's `resources/views/`. For example, to override the login page:

```
resources/views/auth/login.blade.php
```

Your app's version takes precedence automatically — no configuration needed.

To override the authenticated layout, create `resources/views/components/layouts/app.blade.php` — this will take precedence over the package's sidebar layout.

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
