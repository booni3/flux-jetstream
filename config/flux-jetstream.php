<?php

return [
    'brand' => [
        'name' => env('APP_NAME', 'Laravel'),
        'logo' => null,         // e.g. '/img/logo.png'
        'logo_dark' => null,    // optional dark mode variant (used on colored background)
        'auth_logo' => null,    // image path ('/img/logo.png') or component name ('pslogo')
        'url' => '/',           // logo link target
        'color' => null,        // e.g. 'bg-cyan-400' — solid background behind logo
    ],

    'sidebar' => [
        'style' => 'light',     // 'dark' or 'light'
        'bg' => '#1E2938',      // sidebar background (dark style only)
        'border' => null,       // border color class, e.g. 'border-gray-900' (null = default)
        'collapsed_default' => true, // start collapsed on first visit
    ],

    'body_bg' => null,          // e.g. '#F3F4F6' — main content area background
];
