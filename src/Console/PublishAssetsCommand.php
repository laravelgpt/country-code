<?php

namespace Laravelgpt\CountryCode\Console;

use Illuminate\Console\Command;

class PublishAssetsCommand extends Command
{
    protected $signature = 'country-code:publish-assets 
                            {--frontend=all : Frontend framework (blade, livewire, vue, react, alpine, all)}
                            {--force : Overwrite existing files}';

    protected $description = 'Publish Country Code package assets for different frontend frameworks';

    public function handle()
    {
        $frontend = $this->option('frontend');
        $force = $this->option('force');

        $this->info('📦 Publishing Country Code Assets...');
        $this->newLine();

        if ($frontend === 'all' || $frontend === 'blade') {
            $this->publishBladeAssets($force);
        }

        if ($frontend === 'all' || $frontend === 'livewire') {
            $this->publishLivewireAssets($force);
        }

        if ($frontend === 'all' || $frontend === 'vue') {
            $this->publishVueAssets($force);
        }

        if ($frontend === 'all' || $frontend === 'react') {
            $this->publishReactAssets($force);
        }

        if ($frontend === 'all' || $frontend === 'alpine') {
            $this->publishAlpineAssets($force);
        }

        $this->newLine();
        $this->info('✅ Assets published successfully!');
    }

    protected function publishBladeAssets(bool $force): void
    {
        $this->info('📄 Publishing Blade components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'views',
            '--force' => $force
        ]);
    }

    protected function publishLivewireAssets(bool $force): void
    {
        $this->info('⚡ Publishing Livewire components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'livewire',
            '--force' => $force
        ]);
    }

    protected function publishVueAssets(bool $force): void
    {
        $this->info('🟢 Publishing Vue components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'vue',
            '--force' => $force
        ]);
    }

    protected function publishReactAssets(bool $force): void
    {
        $this->info('⚛️ Publishing React components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'react',
            '--force' => $force
        ]);
    }

    protected function publishAlpineAssets(bool $force): void
    {
        $this->info('🏔️ Publishing Alpine.js components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'js',
            '--force' => $force
        ]);
    }
} 