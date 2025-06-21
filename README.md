# Laravel Country Code Package

A comprehensive Laravel package providing extensive country data including phone codes, ISO codes, flag emojis, and regional groupings.

## Features

- 🌍 **200+ Countries**: Complete database of all recognized countries
- 📞 **Phone Codes**: International dialing codes and formats
- 🏳️ **Flag Emojis**: Unicode flag representations
- 📋 **ISO Codes**: ISO 3166-1 alpha-2 and alpha-3 codes
- 🌐 **Regional Groupings**: Continents, regions, and economic unions
- 🗃️ **Database Integration**: Seamless Laravel Eloquent models
- 🔍 **Search & Filter**: Find countries by various criteria
- 📊 **Validation**: Built-in country code validation
- 🎨 **Blade Components**: Ready-to-use UI components

## Requirements

- PHP 8.2 or higher
- Laravel 10.x or 11.x

## Installation

```bash
composer require laravel/country-code
```

### Publish Configuration

```bash
php artisan vendor:publish --provider="Laravel\CountryCode\CountryCodeServiceProvider"
```

### Run Migrations

```bash
php artisan migrate
```

### Seed Database

```bash
php artisan country-code:seed
```

## Quick Start

### Using the Facade

```php
use Laravel\CountryCode\Facades\CountryCode;

// Get all countries
$countries = CountryCode::all();

// Find by ISO code
$usa = CountryCode::findByIso('US');

// Find by phone code
$countries = CountryCode::findByPhoneCode('1');

// Get countries by continent
$europeanCountries = CountryCode::getByContinent('Europe');
```

### Using Eloquent Models

```php
use Laravel\CountryCode\Models\Country;

// Find country by ISO
$country = Country::where('iso_alpha2', 'US')->first();

// Get phone code
echo $country->phone_code; // +1

// Get flag emoji
echo $country->flag_emoji; // 🇺🇸
```

### Validation

```php
use Laravel\CountryCode\Rules\ValidCountryCode;

$request->validate([
    'country_code' => ['required', new ValidCountryCode],
]);
```

## Configuration

Publish the config file to customize the package:

```bash
php artisan vendor:publish --provider="Laravel\CountryCode\CountryCodeServiceProvider" --tag="config"
```

## API Reference

### CountryCode Facade Methods

- `all()` - Get all countries
- `findByIso(string $iso)` - Find country by ISO code
- `findByPhoneCode(string $phoneCode)` - Find countries by phone code
- `getByContinent(string $continent)` - Get countries by continent
- `getByRegion(string $region)` - Get countries by region
- `search(string $query)` - Search countries by name
- `validate(string $code)` - Validate country code

### Country Model Attributes

- `name` - Country name
- `iso_alpha2` - ISO 3166-1 alpha-2 code
- `iso_alpha3` - ISO 3166-1 alpha-3 code
- `phone_code` - International dialing code
- `flag_emoji` - Unicode flag emoji
- `continent` - Continent name
- `region` - Geographic region
- `capital` - Capital city
- `currency_code` - Currency ISO code
- `currency_name` - Currency name
- `timezone` - Primary timezone
- `languages` - Official languages (JSON)

## Blade Components

### Country Selector

```blade
<x-country-code::selector 
    name="country" 
    :selected="$selectedCountry"
    placeholder="Select a country"
/>
```

### Country Flag

```blade
<x-country-code::flag 
    :country="$country" 
    size="lg"
/>
```

### Phone Code Input

```blade
<x-country-code::phone-input 
    name="phone" 
    :country="$country"
/>
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 