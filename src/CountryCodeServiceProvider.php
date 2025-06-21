<?php

namespace Laravel\CountryCode;

use Illuminate\Support\ServiceProvider;
use Laravel\CountryCode\Services\CountryCodeService;

class CountryCodeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/country-code.php', 'country-code'
        );

        $this->app->singleton(CountryCodeService::class, function ($app) {
            return new CountryCodeService();
        });

        $this->app->alias(CountryCodeService::class, 'country-code');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publish configuration
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/country-code.php' => config_path('country-code.php'),
            ], 'config');

            // Publish migrations
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');

            // Publish seeders
            $this->publishes([
                __DIR__.'/../database/seeders' => database_path('seeders'),
            ], 'seeders');

            // Register commands
            $this->commands([
                \Laravel\CountryCode\Console\SeedCountriesCommand::class,
            ]);
        }

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'country-code');

        // Load blade components
        $this->loadViewComponentsAs('country-code', [
            \Laravel\CountryCode\View\Components\CountrySelector::class,
            \Laravel\CountryCode\View\Components\CountryFlag::class,
            \Laravel\CountryCode\View\Components\PhoneInput::class,
        ]);
    }
} 