# Laravel Country Code Package - Complete Structure

## 📦 Package Overview

A comprehensive Laravel package providing extensive country data including phone codes, ISO codes, flag emojis, and regional groupings with PHP 8.2+ support.

## 🏗️ Package Structure

```
laravel-country-code/
├── composer.json                 # Package configuration
├── README.md                     # Comprehensive documentation
├── LICENSE.md                    # MIT License
├── CONTRIBUTING.md               # Contributing guidelines
├── CHANGELOG.md                  # Version history
├── PACKAGE_STRUCTURE.md          # This file
├── phpunit.xml                   # PHPUnit configuration
│
├── config/
│   └── country-code.php          # Package configuration
│
├── src/
│   ├── CountryCodeServiceProvider.php    # Main service provider
│   ├── Services/
│   │   └── CountryCodeService.php        # Core service class
│   ├── Models/
│   │   └── Country.php                   # Eloquent model
│   ├── Facades/
│   │   └── CountryCode.php               # Facade for easy access
│   ├── Http/
│   │   └── Controllers/
│   │       └── CountryController.php     # API controller
│   ├── Console/
│   │   └── SeedCountriesCommand.php      # Artisan command
│   ├── Rules/
│   │   └── ValidCountryCode.php          # Validation rule
│   └── View/
│       └── Components/
│           ├── CountrySelector.php       # Blade component class
│           ├── CountryFlag.php           # Blade component class
│           └── PhoneInput.php            # Blade component class
│
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000001_create_countries_table.php
│   └── seeders/
│       └── CountrySeeder.php             # Comprehensive country data
│
├── routes/
│   └── api.php                           # API routes
│
├── resources/
│   └── views/
│       └── components/
│           ├── country-selector.blade.php # Country dropdown component
│           ├── country-flag.blade.php     # Flag display component
│           └── phone-input.blade.php      # Phone input component
│
└── tests/
    └── Feature/
        └── CountryCodeTest.php           # Comprehensive test suite
```

## 🌟 Key Features

### 1. **Comprehensive Country Database**
- 200+ countries with complete information
- Phone codes and international dialing formats
- ISO 3166-1 alpha-2 and alpha-3 codes
- Unicode flag emojis
- Continental and regional groupings
- Currency information and timezone data
- Population and geographic data
- UN membership and independence status

### 2. **Laravel Integration**
- **Eloquent Model**: Full Country model with relationships and scopes
- **Service Layer**: CountryCodeService with caching and search
- **Facade**: Easy access via `CountryCode::` facade
- **API Controller**: RESTful endpoints for all operations
- **Validation**: Custom validation rule for country codes
- **Artisan Commands**: Database seeding and management

### 3. **Blade Components**
- **Country Selector**: Searchable dropdown with flags and phone codes
- **Country Flag**: Display flags with various sizes and options
- **Phone Input**: Phone number input with country code selection

### 4. **API Endpoints**
- `GET /api/countries` - List all countries with pagination
- `GET /api/countries/{code}` - Get specific country by ISO code
- `GET /api/countries/search` - Search countries
- `GET /api/countries/phone/{code}` - Get countries by phone code
- `GET /api/countries/continent/{continent}` - Get countries by continent
- `GET /api/countries/region/{region}` - Get countries by region
- `GET /api/countries/continents` - Get all continents
- `GET /api/countries/regions` - Get all regions
- `POST /api/countries/validate` - Validate country code
- And many more...

### 5. **Configuration System**
- Default country setting
- Supported languages
- Cache configuration
- API settings
- Regional groupings
- Phone number formats
- Database settings

## 🚀 Quick Start

### Installation
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

## 💡 Usage Examples

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

### Using Eloquent Model
```php
use Laravel\CountryCode\Models\Country;

$country = Country::where('iso_alpha2', 'US')->first();
echo $country->phone_code; // 1
echo $country->flag_emoji; // 🇺🇸
```

### Using Blade Components
```blade
<x-country-code::selector 
    name="country" 
    :selected="$selectedCountry"
    placeholder="Select a country"
/>

<x-country-code::flag 
    :country="$country" 
    size="lg"
/>

<x-country-code::phone-input 
    name="phone" 
    :country="$country"
/>
```

### Validation
```php
use Laravel\CountryCode\Rules\ValidCountryCode;

$request->validate([
    'country_code' => ['required', new ValidCountryCode],
]);
```

## 🧪 Testing

### Run Tests
```bash
composer test
```

### Test Coverage
The package includes comprehensive tests covering:
- Service layer functionality
- Model relationships and scopes
- API endpoints
- Validation rules
- Blade components
- Database operations

## 📊 Data Included

### Country Information
- **Basic Data**: Name, ISO codes, phone codes, flags
- **Geographic**: Continent, region, sub-region, capital
- **Economic**: Currency codes, GDP, population
- **Technical**: Timezone, internet TLD, postal formats
- **Political**: UN membership, independence status

### Phone Codes
- International dialing codes
- Country-specific formats
- Validation patterns
- Examples for each country

### Regional Groupings
- **Continents**: Africa, Asia, Europe, North America, South America, Oceania
- **Regions**: Northern America, Western Europe, Eastern Asia, etc.
- **Custom Groups**: EU, NAFTA, ASEAN, etc.

## 🔧 Configuration Options

### Environment Variables
```env
DEFAULT_COUNTRY=US
COUNTRY_CODE_CACHE_ENABLED=true
COUNTRY_CODE_CACHE_TTL=86400
COUNTRY_CODE_API_ENABLED=true
COUNTRY_CODE_API_RATE_LIMIT=60
COUNTRY_CODE_PHONE_FORMAT=international
COUNTRY_CODE_STRICT_MODE=false
```

### Configuration File
The package provides a comprehensive configuration file with:
- Default settings
- Cache configuration
- API settings
- Regional groupings
- Phone formats
- Database settings

## 🌐 API Documentation

### Authentication
All API endpoints are public by default but can be protected using Laravel's authentication middleware.

### Rate Limiting
Configurable rate limiting is available for API endpoints.

### Response Format
All API responses follow a consistent JSON format:
```json
{
    "data": [...],
    "pagination": {
        "current_page": 1,
        "last_page": 10,
        "per_page": 20,
        "total": 200
    }
}
```

## 🔒 Security

- Input validation on all endpoints
- SQL injection protection via Eloquent
- XSS protection in Blade components
- Rate limiting for API endpoints
- Secure configuration handling

## 📈 Performance

- Caching system for frequently accessed data
- Database indexing for optimal queries
- Lazy loading for relationships
- Efficient search algorithms
- Pagination for large datasets

## 🤝 Contributing

The package follows Laravel conventions and includes:
- Comprehensive contributing guidelines
- Code of conduct
- Testing requirements
- Documentation standards
- Review process

## 📄 License

MIT License - see LICENSE.md for details.

## 🆘 Support

- **PHP**: 8.2 or higher
- **Laravel**: 10.x or 11.x
- **Database**: MySQL, PostgreSQL, SQLite, SQL Server
- **Documentation**: Comprehensive README and inline docs
- **Testing**: Full test suite with examples

---

This package provides everything needed to work with country data in Laravel applications, from basic country lookups to complex regional analysis and phone number handling. 