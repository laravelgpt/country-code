<?php

namespace Laravelgpt\CountryCode\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'country-code:install 
                            {--frontend=blade : Frontend framework (blade, livewire, vue, react, alpine)}
                            {--publish-all : Publish all assets}
                            {--skip-migrations : Skip running migrations}
                            {--skip-seeding : Skip seeding the database}
                            {--force : Force installation without confirmation}';

    protected $description = 'Install LaravelGPT Country Code package with frontend framework selection';

    public function handle()
    {
        $this->info('🚀 Installing LaravelGPT Country Code Package...');
        $this->newLine();

        // Check if user wants to proceed
        if (!$this->option('force') && !$this->confirm('Do you want to proceed with the installation?')) {
            $this->info('Installation cancelled.');
            return;
        }

        $frontend = $this->option('frontend');
        $publishAll = $this->option('publish-all');

        // Step 1: Publish configuration
        $this->info('📋 Publishing configuration...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'config'
        ]);

        // Step 2: Publish migrations
        $this->info('🗄️ Publishing migrations...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'migrations'
        ]);

        // Step 3: Publish seeders
        $this->info('🌱 Publishing seeders...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'seeders'
        ]);

        // Step 4: Setup frontend framework
        $this->setupFrontend($frontend, $publishAll);

        // Step 5: Run migrations
        if (!$this->option('skip-migrations')) {
            $this->info('🔄 Running migrations...');
            $this->call('migrate');
        }

        // Step 6: Seed database
        if (!$this->option('skip-seeding')) {
            $this->info('🌱 Seeding database...');
            $this->call('country-code:seed');
        }

        // Step 7: Create example files
        $this->createExampleFiles($frontend);

        $this->newLine();
        $this->info('✅ LaravelGPT Country Code Package installed successfully!');
        $this->newLine();
        
        $this->displayNextSteps($frontend);
    }

    protected function setupFrontend(string $frontend, bool $publishAll): void
    {
        $this->info("🎨 Setting up {$frontend} frontend...");

        switch ($frontend) {
            case 'blade':
                $this->setupBlade($publishAll);
                break;
            case 'livewire':
                $this->setupLivewire($publishAll);
                break;
            case 'vue':
                $this->setupVue($publishAll);
                break;
            case 'react':
                $this->setupReact($publishAll);
                break;
            case 'alpine':
                $this->setupAlpine($publishAll);
                break;
            default:
                $this->error("Unsupported frontend framework: {$frontend}");
                return;
        }
    }

    protected function setupBlade(bool $publishAll): void
    {
        $this->info('📄 Publishing Blade components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'views'
        ]);

        if ($publishAll) {
            $this->call('vendor:publish', [
                '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
                '--tag' => 'css'
            ]);
        }
    }

    protected function setupLivewire(bool $publishAll): void
    {
        // Check if Livewire is installed
        if (!class_exists('Livewire\Livewire')) {
            $this->error('Livewire is not installed. Please install it first: composer require livewire/livewire');
            return;
        }

        $this->info('⚡ Publishing Livewire components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'livewire'
        ]);

        if ($publishAll) {
            $this->call('vendor:publish', [
                '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
                '--tag' => 'css'
            ]);
        }
    }

    protected function setupVue(bool $publishAll): void
    {
        $this->info('🟢 Publishing Vue components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'vue'
        ]);

        if ($publishAll) {
            $this->call('vendor:publish', [
                '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
                '--tag' => 'js'
            ]);
        }

        $this->info('📝 Adding Vue components to your app...');
        $this->addVueToApp();
    }

    protected function setupReact(bool $publishAll): void
    {
        $this->info('⚛️ Publishing React components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'react'
        ]);

        if ($publishAll) {
            $this->call('vendor:publish', [
                '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
                '--tag' => 'js'
            ]);
        }

        $this->info('📝 Adding React components to your app...');
        $this->addReactToApp();
    }

    protected function setupAlpine(bool $publishAll): void
    {
        $this->info('🏔️ Publishing Alpine.js components...');
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'js'
        ]);

        if ($publishAll) {
            $this->call('vendor:publish', [
                '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
                '--tag' => 'css'
            ]);
        }
    }

    protected function addVueToApp(): void
    {
        $appJsPath = resource_path('js/app.js');
        
        if (File::exists($appJsPath)) {
            $content = File::get($appJsPath);
            
            if (!str_contains($content, 'country-code')) {
                $vueImport = "\n// Country Code Components\nimport CountrySelector from './vendor/country-code/vue/CountrySelector.vue';\nimport CountryFlag from './vendor/country-code/vue/CountryFlag.vue';\nimport PhoneInput from './vendor/country-code/vue/PhoneInput.vue';\n\n// Register components\napp.component('country-selector', CountrySelector);\napp.component('country-flag', CountryFlag);\napp.component('phone-input', PhoneInput);\n";
                
                File::put($appJsPath, $content . $vueImport);
                $this->info('✅ Vue components added to app.js');
            }
        }
    }

    protected function addReactToApp(): void
    {
        $appJsPath = resource_path('js/app.js');
        
        if (File::exists($appJsPath)) {
            $content = File::get($appJsPath);
            
            if (!str_contains($content, 'country-code')) {
                $reactImport = "\n// Country Code Components\nimport CountrySelector from './vendor/country-code/react/CountrySelector';\nimport CountryFlag from './vendor/country-code/react/CountryFlag';\nimport PhoneInput from './vendor/country-code/react/PhoneInput';\n\n// Export components\nwindow.CountrySelector = CountrySelector;\nwindow.CountryFlag = CountryFlag;\nwindow.PhoneInput = PhoneInput;\n";
                
                File::put($appJsPath, $content . $reactImport);
                $this->info('✅ React components added to app.js');
            }
        }
    }

    protected function createExampleFiles(string $frontend): void
    {
        $this->info('📝 Creating example files...');

        $examplesPath = resource_path('views/examples/country-code');
        File::makeDirectory($examplesPath, 0755, true, true);

        $this->createExampleBlade($examplesPath);
        
        if ($frontend === 'livewire') {
            $this->createExampleLivewire($examplesPath);
        }
    }

    protected function createExampleBlade(string $path): void
    {
        $bladeExample = <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Country Code Examples</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Country Selector -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Country Selector</h2>
            <x-country-code::country-selector 
                name="country" 
                placeholder="Select a country..."
                show-flag="true"
                show-phone-code="true"
            />
        </div>

        <!-- Country Flag -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Country Flag</h2>
            <x-country-code::country-flag 
                code="US" 
                size="lg"
                show-name="true"
            />
        </div>

        <!-- Phone Input -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Phone Input</h2>
            <x-country-code::phone-input 
                name="phone" 
                placeholder="Enter phone number..."
                show-country-selector="true"
            />
        </div>

        <!-- Country Search -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Country Search</h2>
            <x-country-code::country-search 
                placeholder="Search countries..."
            />
        </div>
    </div>
</div>
@endsection
BLADE;

        File::put($path . '/blade-example.blade.php', $bladeExample);
    }

    protected function createExampleLivewire(string $path): void
    {
        $livewireExample = <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Livewire Country Code Examples</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Livewire Country Selector -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Livewire Country Selector</h2>
            <livewire:country-code::country-selector />
        </div>

        <!-- Livewire Country Search -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Livewire Country Search</h2>
            <livewire:country-code::country-search />
        </div>

        <!-- Livewire Phone Input -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Livewire Phone Input</h2>
            <livewire:country-code::phone-input />
        </div>

        <!-- Livewire Country Map -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Livewire Country Map</h2>
            <livewire:country-code::country-map />
        </div>
    </div>
</div>
@endsection
BLADE;

        File::put($path . '/livewire-example.blade.php', $livewireExample);
    }

    protected function displayNextSteps(string $frontend): void
    {
        $this->info('🎯 Next Steps:');
        $this->newLine();
        
        $this->line('1. 📖 Read the documentation: https://github.com/laravelgpt/country-code');
        $this->line('2. 🧪 Check out examples: resources/views/examples/country-code/');
        $this->line('3. 🔧 Configure the package: config/country-code.php');
        
        if ($frontend !== 'blade') {
            $this->line("4. 🎨 Customize your {$frontend} components");
        }
        
        $this->newLine();
        $this->info('🚀 Happy coding with LaravelGPT Country Code!');
    }

    public static function postInstall(): void
    {
        // Post-installation tasks
    }

    public static function postUpdate(): void
    {
        // Post-update tasks
    }
} 