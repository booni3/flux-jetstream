<?php

namespace Booni3\FluxJetstream;

use Illuminate\Support\ServiceProvider;

class FluxJetstreamServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flux-jetstream.php', 'flux-jetstream');

        // Add package views as a fallback location. App views at the same
        // path take precedence, so any app can override a specific view
        // simply by placing a file at the matching path in resources/views/.
        $this->app['view']->addLocation(__DIR__.'/../resources/views');

        $this->publishes([
            __DIR__.'/../config/flux-jetstream.php' => config_path('flux-jetstream.php'),
        ], 'flux-jetstream-config');

        // Allow apps to publish individual views for customisation:
        //   php artisan vendor:publish --tag=flux-jetstream-views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/flux-jetstream'),
        ], 'flux-jetstream-views');
    }
}
