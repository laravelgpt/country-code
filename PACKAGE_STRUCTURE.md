# Laravel Country Code Package Structure

## Installation

```bash
composer require laravelgpt/country-code
```

## Publishing Configuration

```bash
php artisan vendor:publish --provider="Laravelgpt\CountryCode\CountryCodeServiceProvider"
```

## Usage Examples

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