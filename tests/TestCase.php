<?php

namespace Laravel\CountryCode\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Laravel\CountryCode\CountryCodeServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            CountryCodeServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Setup cache to use array driver
        $app['config']->set('cache.default', 'array');

        // Setup country-code config
        $app['config']->set('country-code.default_country', 'US');
        $app['config']->set('country-code.cache.enabled', false);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
} 