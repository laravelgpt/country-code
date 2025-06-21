<?php

namespace Laravelgpt\CountryCode\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupFrontendCommand extends Command
{
    protected $signature = 'country-code:setup-frontend 
                            {--framework= : Frontend framework to setup}
                            {--interactive : Interactive setup mode}';

    protected $description = 'Setup frontend framework for Country Code package';

    private array $supportedFrameworks = [
        'blade' => 'Blade Components (Default)',
        'livewire' => 'Livewire Components',
        'vue' => 'Vue.js Components',
        'react' => 'React Components',
        'alpine' => 'Alpine.js Components',
        'all' => 'All Frameworks'
    ];

    public function handle()
    {
        $this->info('🎨 Country Code Frontend Setup');
        $this->newLine();

        $framework = $this->getFrameworkSelection();

        if (!$framework) {
            $this->error('No framework selected. Setup cancelled.');
            return;
        }

        $this->setupFramework($framework);

        $this->newLine();
        $this->info('✅ Frontend setup completed successfully!');
    }

    protected function getFrameworkSelection(): ?string
    {
        $framework = $this->option('framework');

        if ($framework) {
            if (!array_key_exists($framework, $this->supportedFrameworks)) {
                $this->error("Unsupported framework: {$framework}");
                $this->info('Supported frameworks: ' . implode(', ', array_keys($this->supportedFrameworks)));
                return null;
            }
            return $framework;
        }

        if ($this->option('interactive')) {
            return $this->interactiveSelection();
        }

        // Default to blade if no selection
        return 'blade';
    }

    protected function interactiveSelection(): ?string
    {
        $this->info('Available frontend frameworks:');
        $this->newLine();

        $choices = [];
        foreach ($this->supportedFrameworks as $key => $description) {
            $choices[] = $key;
            $this->line("  {$key}: {$description}");
        }

        $this->newLine();
        $selected = $this->choice('Select a frontend framework:', $choices);

        return $selected;
    }

    protected function setupFramework(string $framework): void
    {
        $this->info("Setting up {$this->supportedFrameworks[$framework]}...");

        switch ($framework) {
            case 'blade':
                $this->setupBlade();
                break;
            case 'livewire':
                $this->setupLivewire();
                break;
            case 'vue':
                $this->setupVue();
                break;
            case 'react':
                $this->setupReact();
                break;
            case 'alpine':
                $this->setupAlpine();
                break;
            case 'all':
                $this->setupAll();
                break;
        }
    }

    protected function setupBlade(): void
    {
        $this->info('📄 Setting up Blade components...');
        
        // Publish views
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'views'
        ]);

        // Create example blade file
        $this->createBladeExample();
    }

    protected function setupLivewire(): void
    {
        $this->info('⚡ Setting up Livewire components...');
        
        // Check if Livewire is installed
        if (!class_exists('Livewire\Livewire')) {
            $this->warn('Livewire is not installed. Installing...');
            $this->call('composer', ['require', 'livewire/livewire']);
        }

        // Publish Livewire components
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'livewire'
        ]);

        // Create example Livewire file
        $this->createLivewireExample();
    }

    protected function setupVue(): void
    {
        $this->info('🟢 Setting up Vue.js components...');
        
        // Publish Vue components
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'vue'
        ]);

        // Add to app.js
        $this->addVueToApp();
        
        // Create example Vue file
        $this->createVueExample();
    }

    protected function setupReact(): void
    {
        $this->info('⚛️ Setting up React components...');
        
        // Publish React components
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'react'
        ]);

        // Add to app.js
        $this->addReactToApp();
        
        // Create example React file
        $this->createReactExample();
    }

    protected function setupAlpine(): void
    {
        $this->info('🏔️ Setting up Alpine.js components...');
        
        // Publish Alpine components
        $this->call('vendor:publish', [
            '--provider' => 'Laravelgpt\CountryCode\CountryCodeServiceProvider',
            '--tag' => 'js'
        ]);

        // Create example Alpine file
        $this->createAlpineExample();
    }

    protected function setupAll(): void
    {
        $this->info('🎯 Setting up all frontend frameworks...');
        
        $this->setupBlade();
        $this->setupLivewire();
        $this->setupVue();
        $this->setupReact();
        $this->setupAlpine();
    }

    protected function createBladeExample(): void
    {
        $examplePath = resource_path('views/examples/country-code');
        File::makeDirectory($examplePath, 0755, true, true);

        $content = <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Blade Country Code Examples</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-country-code::country-selector name="country" />
        <x-country-code::country-flag code="US" />
        <x-country-code::phone-input name="phone" />
        <x-country-code::country-search />
    </div>
</div>
@endsection
BLADE;

        File::put($examplePath . '/blade-example.blade.php', $content);
        $this->info('✅ Blade example created: resources/views/examples/country-code/blade-example.blade.php');
    }

    protected function createLivewireExample(): void
    {
        $examplePath = resource_path('views/examples/country-code');
        File::makeDirectory($examplePath, 0755, true, true);

        $content = <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Livewire Country Code Examples</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <livewire:country-code::country-selector />
        <livewire:country-code::country-search />
        <livewire:country-code::phone-input />
        <livewire:country-code::country-map />
    </div>
</div>
@endsection
BLADE;

        File::put($examplePath . '/livewire-example.blade.php', $content);
        $this->info('✅ Livewire example created: resources/views/examples/country-code/livewire-example.blade.php');
    }

    protected function createVueExample(): void
    {
        $examplePath = resource_path('js/examples');
        File::makeDirectory($examplePath, 0755, true, true);

        $content = <<<'JS'
// Vue.js Country Code Example
import CountrySelector from '../vendor/country-code/vue/CountrySelector.vue';
import CountryFlag from '../vendor/country-code/vue/CountryFlag.vue';
import PhoneInput from '../vendor/country-code/vue/PhoneInput.vue';

export default {
    components: {
        CountrySelector,
        CountryFlag,
        PhoneInput
    },
    data() {
        return {
            selectedCountry: null,
            phoneNumber: ''
        }
    }
}
JS;

        File::put($examplePath . '/vue-example.js', $content);
        $this->info('✅ Vue example created: resources/js/examples/vue-example.js');
    }

    protected function createReactExample(): void
    {
        $examplePath = resource_path('js/examples');
        File::makeDirectory($examplePath, 0755, true, true);

        $content = <<<'JSX'
// React Country Code Example
import React, { useState } from 'react';
import CountrySelector from '../vendor/country-code/react/CountrySelector';
import CountryFlag from '../vendor/country-code/react/CountryFlag';
import PhoneInput from '../vendor/country-code/react/PhoneInput';

function CountryCodeExample() {
    const [selectedCountry, setSelectedCountry] = useState(null);
    const [phoneNumber, setPhoneNumber] = useState('');

    return (
        <div>
            <CountrySelector onSelect={setSelectedCountry} />
            <CountryFlag country={selectedCountry} />
            <PhoneInput value={phoneNumber} onChange={setPhoneNumber} />
        </div>
    );
}

export default CountryCodeExample;
JSX;

        File::put($examplePath . '/react-example.jsx', $content);
        $this->info('✅ React example created: resources/js/examples/react-example.jsx');
    }

    protected function createAlpineExample(): void
    {
        $examplePath = resource_path('views/examples/country-code');
        File::makeDirectory($examplePath, 0755, true, true);

        $content = <<<'BLADE'
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6" x-data="countryCodeApp()">
    <h1 class="text-3xl font-bold mb-6">Alpine.js Country Code Examples</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div x-data="{ selectedCountry: null }">
            <label class="block text-sm font-medium mb-2">Select Country</label>
            <select x-model="selectedCountry" class="w-full p-2 border rounded">
                <option value="">Choose a country...</option>
                <template x-for="country in countries" :key="country.code">
                    <option :value="country.code" x-text="country.name"></option>
                </template>
            </select>
        </div>
        
        <div x-show="selectedCountry">
            <span x-text="getCountryFlag(selectedCountry)"></span>
            <span x-text="getCountryName(selectedCountry)"></span>
        </div>
    </div>
</div>

<script>
function countryCodeApp() {
    return {
        countries: [],
        selectedCountry: null,
        
        init() {
            this.loadCountries();
        },
        
        async loadCountries() {
            const response = await fetch('/api/countries');
            this.countries = await response.json();
        },
        
        getCountryFlag(code) {
            const country = this.countries.find(c => c.iso_alpha2 === code);
            return country ? country.flag_emoji : '';
        },
        
        getCountryName(code) {
            const country = this.countries.find(c => c.iso_alpha2 === code);
            return country ? country.name : '';
        }
    }
}
</script>
@endsection
BLADE;

        File::put($examplePath . '/alpine-example.blade.php', $content);
        $this->info('✅ Alpine.js example created: resources/views/examples/country-code/alpine-example.blade.php');
    }

    protected function addVueToApp(): void
    {
        $appJsPath = resource_path('js/app.js');
        
        if (File::exists($appJsPath)) {
            $content = File::get($appJsPath);
            
            if (!str_contains($content, 'country-code')) {
                $vueImport = "\n// Country Code Vue Components\nimport CountrySelector from './vendor/country-code/vue/CountrySelector.vue';\nimport CountryFlag from './vendor/country-code/vue/CountryFlag.vue';\nimport PhoneInput from './vendor/country-code/vue/PhoneInput.vue';\n\n// Register components\napp.component('country-selector', CountrySelector);\napp.component('country-flag', CountryFlag);\napp.component('phone-input', PhoneInput);\n";
                
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
                $reactImport = "\n// Country Code React Components\nimport CountrySelector from './vendor/country-code/react/CountrySelector';\nimport CountryFlag from './vendor/country-code/react/CountryFlag';\nimport PhoneInput from './vendor/country-code/react/PhoneInput';\n\n// Export components\nwindow.CountrySelector = CountrySelector;\nwindow.CountryFlag = CountryFlag;\nwindow.PhoneInput = PhoneInput;\n";
                
                File::put($appJsPath, $content . $reactImport);
                $this->info('✅ React components added to app.js');
            }
        }
    }
} 