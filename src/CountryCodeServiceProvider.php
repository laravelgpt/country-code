<?php

namespace Laravelgpt\CountryCode;

use Illuminate\Support\ServiceProvider;
use Laravelgpt\CountryCode\Services\CountryCodeService;
use Laravelgpt\CountryCode\Console\InstallCommand;
use Laravelgpt\CountryCode\Console\SeedCountriesCommand;
use Laravelgpt\CountryCode\Console\PublishAssetsCommand;
use Laravelgpt\CountryCode\Console\SetupFrontendCommand;

class CountryCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/country-code.php', 'country-code');

        // Register the main service
        $this->app->singleton(CountryCodeService::class, function ($app) {
            return new CountryCodeService();
        });

        // Register the facade
        $this->app->alias(CountryCodeService::class, 'country-code');

        // Register commands
        $this->commands([
            InstallCommand::class,
            SeedCountriesCommand::class,
            PublishAssetsCommand::class,
            SetupFrontendCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/country-code.php' => config_path('country-code.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Publish seeders
        $this->publishes([
            __DIR__ . '/../database/seeders' => database_path('seeders'),
        ], 'seeders');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/country-code'),
        ], 'views');

        // Publish JavaScript assets
        $this->publishes([
            __DIR__ . '/../resources/js' => resource_path('js/vendor/country-code'),
        ], 'js');

        // Publish CSS assets
        $this->publishes([
            __DIR__ . '/../resources/css' => resource_path('css/vendor/country-code'),
        ], 'css');

        // Publish Livewire components
        $this->publishes([
            __DIR__ . '/../resources/livewire' => resource_path('livewire/vendor/country-code'),
        ], 'livewire');

        // Publish Vue components
        $this->publishes([
            __DIR__ . '/../resources/vue' => resource_path('js/vendor/country-code/vue'),
        ], 'vue');

        // Publish React components
        $this->publishes([
            __DIR__ . '/../resources/react' => resource_path('js/vendor/country-code/react'),
        ], 'react');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Load view components
        $this->loadViewComponentsAs('country-code', [
            \Laravelgpt\CountryCode\View\Components\CountrySelector::class,
            \Laravelgpt\CountryCode\View\Components\CountryFlag::class,
            \Laravelgpt\CountryCode\View\Components\PhoneInput::class,
            \Laravelgpt\CountryCode\View\Components\CountrySearch::class,
            \Laravelgpt\CountryCode\View\Components\CountryMap::class,
            \Laravelgpt\CountryCode\View\Components\CountryStats::class,
        ]);

        // Load Livewire components
        $this->loadLivewireComponents();

        // Register middleware
        $this->registerMiddleware();

        // Register macros
        $this->registerMacros();

        // Register observers
        $this->registerObservers();

        // Register events
        $this->registerEvents();
    }

    /**
     * Load Livewire components
     */
    protected function loadLivewireComponents(): void
    {
        if (class_exists('Livewire\Livewire')) {
            \Livewire\Livewire::component('country-code::country-selector', \Laravelgpt\CountryCode\Livewire\CountrySelector::class);
            \Livewire\Livewire::component('country-code::country-search', \Laravelgpt\CountryCode\Livewire\CountrySearch::class);
            \Livewire\Livewire::component('country-code::country-map', \Laravelgpt\CountryCode\Livewire\CountryMap::class);
            \Livewire\Livewire::component('country-code::phone-input', \Laravelgpt\CountryCode\Livewire\PhoneInput::class);
        }
    }

    /**
     * Register middleware
     */
    protected function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('country-code.cache', \Laravelgpt\CountryCode\Http\Middleware\CountryCodeCache::class);
        $this->app['router']->aliasMiddleware('country-code.auth', \Laravelgpt\CountryCode\Http\Middleware\CountryCodeAuth::class);
    }

    /**
     * Register macros
     */
    protected function registerMacros(): void
    {
        // Collection macros
        \Illuminate\Support\Collection::macro('toCountryArray', function () {
            return $this->map(function ($country) {
                return [
                    'code' => $country->iso_alpha2,
                    'name' => $country->name,
                    'flag' => $country->flag_emoji,
                    'phone_code' => $country->phone_code,
                ];
            })->toArray();
        });

        // String macros
        \Illuminate\Support\Str::macro('toCountryCode', function ($string) {
            return \Laravelgpt\CountryCode\Facades\CountryCode::findByName($string)?->iso_alpha2;
        });
    }

    /**
     * Register observers
     */
    protected function registerObservers(): void
    {
        \Laravelgpt\CountryCode\Models\Country::observe(\Laravelgpt\CountryCode\Observers\CountryObserver::class);
    }

    /**
     * Register events
     */
    protected function registerEvents(): void
    {
        $this->app['events']->listen(
            \Laravelgpt\CountryCode\Events\CountryCreated::class,
            \Laravelgpt\CountryCode\Listeners\LogCountryActivity::class
        );
    }
} 