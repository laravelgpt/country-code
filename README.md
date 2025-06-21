# LaravelGPT Country Code Package

A comprehensive Laravel package for country codes, phone codes, ISO codes, flags, and regional data with multi-framework frontend support.

## 🌟 Features

### Core Features
- **200+ Countries** with complete information
- **Phone codes** and international dialing formats
- **ISO 3166-1** alpha-2 and alpha-3 codes
- **Unicode flag emojis** and SVG flag support
- **Continental and regional groupings**
- **UN membership** and independence status
- **Currency information** and timezone data
- **Population and geographic data**

### Frontend Framework Support
- **Blade Components** (Default - No additional dependencies)
- **Livewire Components** (Requires `livewire/livewire`)
- **Vue.js Components** (Requires `vue` npm package)
- **React Components** (Requires `react` npm package)
- **Alpine.js Components** (Requires `alpinejs` npm package)

### Advanced Features
- **Interactive Country Maps** with Leaflet.js
- **Advanced Search** with filters and autocomplete
- **Statistics Dashboard** with charts and exports
- **Multi-language Support** (12+ languages)
- **API Rate Limiting** and caching
- **Regional Groupings** (EU, G7, G20, ASEAN, etc.)
- **Phone Number Validation** and formatting
- **Export Functionality** (JSON, CSV, PDF)

## 📋 Requirements

### PHP Requirements
- **PHP**: 8.2 or higher
- **Laravel**: 10.x or 11.x

### Frontend Dependencies
The package includes a `package.json` file with recommended frontend dependencies:

```bash
# Install frontend dependencies (optional)
npm install

# Or install specific frameworks as needed:
npm install alpinejs        # For Alpine.js components
npm install vue             # For Vue.js components
npm install react react-dom # For React components
npm install leaflet         # For interactive maps
npm install chart.js        # For statistics charts
```

## 🚀 Quick Installation

### Basic Installation (Blade Only)
```bash
composer require laravelgpt/country-code
php artisan country-code:install
```

### Interactive Installation with Frontend Selection
```bash
php artisan country-code:install --interactive
```

### Installation with Specific Frontend Framework
```bash
# Blade (Default - No additional dependencies)
php artisan country-code:install --frontend=blade

# Livewire (Requires livewire/livewire)
composer require livewire/livewire
php artisan country-code:install --frontend=livewire

# Vue.js (Requires vue npm package)
npm install vue
php artisan country-code:install --frontend=vue

# React (Requires react npm package)
npm install react react-dom
php artisan country-code:install --frontend=react

# Alpine.js (Requires alpinejs npm package)
npm install alpinejs
php artisan country-code:install --frontend=alpine

# All frameworks
npm install
php artisan country-code:install --frontend=all
```

### Advanced Installation Options
```bash
# Install with all assets
php artisan country-code:install --publish-all

# Skip migrations
php artisan country-code:install --skip-migrations

# Skip seeding
php artisan country-code:install --skip-seeding

# Force installation without confirmation
php artisan country-code:install --force
```

## 📋 Manual Setup

### 1. Publish Configuration
```bash
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="config"
```

### 2. Publish Migrations
```bash
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="migrations"
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Seed Database
```bash
php artisan country-code:seed
```

### 5. Publish Frontend Assets
```bash
# Blade components (no dependencies required)
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="views"

# Livewire components (requires livewire/livewire)
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="livewire"

# Vue components (requires vue npm package)
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="vue"

# React components (requires react npm package)
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="react"

# Alpine.js components (requires alpinejs npm package)
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider" --tag="js"
```

## 🎨 Frontend Framework Usage

### Blade Components (No Dependencies Required)
```blade
<!-- Country Selector -->
<x-country-code::country-selector 
    name="country" 
    placeholder="Select a country..."
    show-flag="true"
    show-phone-code="true"
    group-by="continent"
/>

<!-- Country Flag -->
<x-country-code::country-flag 
    code="US" 
    size="lg"
    show-name="true"
/>

<!-- Phone Input -->
<x-country-code::phone-input 
    name="phone" 
    placeholder="Enter phone number..."
    show-country-selector="true"
/>

<!-- Country Search -->
<x-country-code::country-search 
    placeholder="Search countries..."
    show-flag="true"
    show-phone-code="true"
/>

<!-- Country Map -->
<x-country-code::country-map 
    interactive="true"
    show-tooltips="true"
    theme="light"
/>

<!-- Country Stats -->
<x-country-code::country-stats 
    show-charts="true"
    show-tables="true"
    limit="10"
/>
```

### Livewire Components (Requires `livewire/livewire`)
```blade
<!-- Livewire Country Selector -->
<livewire:country-code::country-selector />

<!-- Livewire Country Search -->
<livewire:country-code::country-search />

<!-- Livewire Phone Input -->
<livewire:country-code::phone-input />

<!-- Livewire Country Map -->
<livewire:country-code::country-map />
```

### Vue.js Components (Requires `vue` npm package)
```vue
<template>
  <div>
    <country-selector @country-selected="handleCountrySelect" />
    <country-flag :country="selectedCountry" />
    <phone-input v-model="phoneNumber" />
    <country-search @country-selected="handleCountrySelect" />
  </div>
</template>

<script>
import CountrySelector from './vendor/country-code/vue/CountrySelector.vue'
import CountryFlag from './vendor/country-code/vue/CountryFlag.vue'
import PhoneInput from './vendor/country-code/vue/PhoneInput.vue'
import CountrySearch from './vendor/country-code/vue/CountrySearch.vue'

export default {
  components: {
    CountrySelector,
    CountryFlag,
    PhoneInput,
    CountrySearch
  },
  data() {
    return {
      selectedCountry: null,
      phoneNumber: ''
    }
  },
  methods: {
    handleCountrySelect(country) {
      this.selectedCountry = country
    }
  }
}
</script>
```

### React Components
```jsx
import React, { useState } from 'react'
import CountrySelector from './vendor/country-code/react/CountrySelector'
import CountryFlag from './vendor/country-code/react/CountryFlag'
import PhoneInput from './vendor/country-code/react/PhoneInput'
import CountrySearch from './vendor/country-code/react/CountrySearch'

function CountryCodeExample() {
  const [selectedCountry, setSelectedCountry] = useState(null)
  const [phoneNumber, setPhoneNumber] = useState('')

  return (
    <div>
      <CountrySelector onSelect={setSelectedCountry} />
      <CountryFlag country={selectedCountry} />
      <PhoneInput value={phoneNumber} onChange={setPhoneNumber} />
      <CountrySearch onSelect={setSelectedCountry} />
    </div>
  )
}

export default CountryCodeExample
```

### Alpine.js Components
```blade
<div x-data="countryCodeApp()">
  <div class="country-selector">
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

<script>
function countryCodeApp() {
  return {
    countries: [],
    selectedCountry: null,
    
    init() {
      this.loadCountries()
    },
    
    async loadCountries() {
      const response = await fetch('/api/countries')
      this.countries = await response.json()
    },
    
    getCountryFlag(code) {
      const country = this.countries.find(c => c.iso_alpha2 === code)
      return country ? country.flag_emoji : ''
    },
    
    getCountryName(code) {
      const country = this.countries.find(c => c.iso_alpha2 === code)
      return country ? country.name : ''
    }
  }
}
</script>
```

## 🔧 Backend Usage

### Using the Facade
```php
use Laravelgpt\CountryCode\Facades\CountryCode;

// Get all countries
$countries = CountryCode::all();

// Find country by ISO code
$country = CountryCode::findByIso('US');

// Find country by phone code
$country = CountryCode::findByPhoneCode('1');

// Search countries
$results = CountryCode::search('United');

// Get countries by continent
$europeanCountries = CountryCode::getByContinent('Europe');

// Get countries by region
$westernCountries = CountryCode::getByRegion('Western Europe');

// Get UN member countries
$unMembers = CountryCode::getUnMembers();

// Get independent countries
$independent = CountryCode::getIndependent();

// Get default country
$default = CountryCode::getDefaultCountry();

// Validate country code
$isValid = CountryCode::validate('US');

// Get statistics
$stats = CountryCode::getStats();
```

### Using the Model
```php
use Laravelgpt\CountryCode\Models\Country;

// Find country by ISO
$country = Country::where('iso_alpha2', 'US')->first();

// Get phone code
echo $country->phone_code; // 1

// Get flag emoji
echo $country->flag_emoji; // 🇺🇸

// Get country name
echo $country->name; // United States

// Get region
echo $country->region; // North America

// Get continent
echo $country->continent; // Americas
```

### Validation Rule
```php
use Laravelgpt\CountryCode\Rules\ValidCountryCode;

$request->validate([
    'country_code' => ['required', new ValidCountryCode],
]);
```

### API Endpoints
```php
// Get all countries
GET /api/countries

// Get specific country
GET /api/countries/{code}

// Search countries
GET /api/countries/search?q=United

// Get countries by phone code
GET /api/countries/phone/{phoneCode}

// Get countries by continent
GET /api/countries/continent/{continent}

// Get countries by region
GET /api/countries/region/{region}

// Get all continents
GET /api/countries/continents

// Get all regions
GET /api/countries/regions

// Validate country code
POST /api/countries/validate

// Get statistics
GET /api/countries/stats
```

## ⚙️ Configuration

### Environment Variables
```env
# Default country
COUNTRY_CODE_DEFAULT=US

# Cache settings
COUNTRY_CODE_CACHE_ENABLED=true
COUNTRY_CODE_CACHE_TTL=86400
COUNTRY_CODE_CACHE_PREFIX=country_code

# API settings
COUNTRY_CODE_API_ENABLED=true
COUNTRY_CODE_API_RATE_LIMIT=100
COUNTRY_CODE_API_TIMEOUT=30

# Frontend framework
COUNTRY_CODE_FRONTEND=blade
COUNTRY_CODE_LIVEWIRE_ENABLED=false
COUNTRY_CODE_VUE_ENABLED=false
COUNTRY_CODE_REACT_ENABLED=false
COUNTRY_CODE_ALPINE_ENABLED=false

# Phone number format
COUNTRY_CODE_PHONE_FORMAT=international

# Flag type
COUNTRY_CODE_FLAG_TYPE=emoji

# Database settings
COUNTRY_CODE_TABLE_NAME=countries
COUNTRY_CODE_AUTO_MIGRATE=true
COUNTRY_CODE_AUTO_SEED=true

# Logging
COUNTRY_CODE_LOGGING_ENABLED=true
COUNTRY_CODE_LOG_CHANNEL=daily
COUNTRY_CODE_LOG_LEVEL=info

# Development
COUNTRY_CODE_DEBUG=false
COUNTRY_CODE_PROFILING=false
COUNTRY_CODE_TESTING=false
```

### Configuration File
The package configuration file (`config/country-code.php`) contains comprehensive settings for:
- Default country
- Supported languages
- Cache configuration
- API settings
- Frontend framework configuration
- Regional groupings
- Phone number configuration
- Flag configuration
- Database settings
- Security settings
- Logging configuration
- Performance optimization
- Customization paths
- Development settings

## 🛠️ Available Commands

### Installation Commands
```bash
# Interactive installation
php artisan country-code:install --interactive

# Install with specific frontend
php artisan country-code:install --frontend=vue

# Install with all assets
php artisan country-code:install --publish-all
```

### Setup Commands
```bash
# Setup frontend framework
php artisan country-code:setup-frontend --framework=vue

# Interactive frontend setup
php artisan country-code:setup-frontend --interactive
```

### Asset Commands
```bash
# Publish all assets
php artisan country-code:publish-assets --frontend=all

# Publish specific framework assets
php artisan country-code:publish-assets --frontend=vue

# Force overwrite existing files
php artisan country-code:publish-assets --force
```

### Database Commands
```bash
# Seed countries
php artisan country-code:seed

# Seed with confirmation
php artisan country-code:seed --confirm
```

## 📊 Statistics and Analytics

### Built-in Statistics
- Total countries count
- Countries by continent
- Countries by region
- Phone code distribution
- Regional groupings
- Export functionality (JSON, CSV, PDF)

### Custom Analytics
```php
// Get continent statistics
$continentStats = CountryCode::getContinentStats();

// Get region statistics
$regionStats = CountryCode::getRegionStats();

// Get phone code statistics
$phoneStats = CountryCode::getPhoneStats();

// Get custom groupings
$euCountries = CountryCode::getByRegionalGroup('eu');
$g7Countries = CountryCode::getByRegionalGroup('g7');
```

## 🔒 Security Features

### Rate Limiting
- Configurable API rate limiting
- Per-user and per-IP limits
- Customizable decay periods

### CORS Support
- Configurable CORS settings
- Allowed origins, methods, and headers
- Secure by default

### Authentication
- Optional authentication requirements
- Configurable guards and middleware
- Role-based access control

## 🚀 Performance Optimization

### Caching
- Intelligent caching system
- Configurable TTL and prefixes
- Cache invalidation strategies

### Database Optimization
- Eager loading support
- Query optimization
- Database indexes
- Pagination support

### Asset Optimization
- Minified JavaScript and CSS
- Optimized component loading
- Tree-shaking support

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter=CountryCodeTest

# Run with coverage
php artisan test --coverage
```

### Test Examples
```php
// Test facade functionality
$this->assertNotNull(CountryCode::findByIso('US'));

// Test validation rule
$this->assertTrue((new ValidCountryCode)->passes('country', 'US'));

// Test API endpoints
$this->get('/api/countries')->assertStatus(200);
```

## 📚 Examples and Documentation

### Example Files
After installation, example files are created in:
- `resources/views/examples/country-code/blade-example.blade.php`
- `resources/views/examples/country-code/livewire-example.blade.php`
- `resources/js/examples/vue-example.js`
- `resources/js/examples/react-example.jsx`
- `resources/views/examples/country-code/alpine-example.blade.php`

### Documentation
- [API Documentation](https://github.com/laravelgpt/country-code/wiki/API)
- [Component Documentation](https://github.com/laravelgpt/country-code/wiki/Components)
- [Configuration Guide](https://github.com/laravelgpt/country-code/wiki/Configuration)
- [Frontend Integration](https://github.com/laravelgpt/country-code/wiki/Frontend)

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup
```bash
# Clone the repository
git clone https://github.com/laravelgpt/country-code.git

# Install dependencies
composer install

# Run tests
php artisan test

# Run linting
./vendor/bin/pint
```

## 📄 License

This package is open-sourced software licensed under the [MIT License](LICENSE.md).

## 🆘 Support

- **Documentation**: [GitHub Wiki](https://github.com/laravelgpt/country-code/wiki)
- **Issues**: [GitHub Issues](https://github.com/laravelgpt/country-code/issues)
- **Discussions**: [GitHub Discussions](https://github.com/laravelgpt/country-code/discussions)
- **Email**: support@laravelgpt-country-code.com

## 🎯 Roadmap

### Upcoming Features
- [ ] GeoJSON country boundaries
- [ ] Advanced mapping features
- [ ] Real-time data updates
- [ ] Mobile app support
- [ ] GraphQL API
- [ ] Machine learning integration
- [ ] Advanced analytics dashboard
- [ ] Multi-tenant support
- [ ] API versioning
- [ ] Webhook support

### Version History
- **v2.0.0**: Multi-framework support, interactive maps, advanced statistics
- **v1.0.0**: Initial release with basic functionality

---

**Made with ❤️ by the LaravelGPT Team** 