<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Country
    |--------------------------------------------------------------------------
    |
    | The default country to use when no specific country is selected.
    | This should be a valid ISO 3166-1 alpha-2 country code.
    |
    */
    'default_country' => env('DEFAULT_COUNTRY', 'US'),

    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | List of supported languages for country names and descriptions.
    | The first language will be used as the default.
    |
    */
    'supported_languages' => [
        'en' => 'English',
        'es' => 'Spanish',
        'fr' => 'French',
        'de' => 'German',
        'it' => 'Italian',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'zh' => 'Chinese',
        'ja' => 'Japanese',
        'ko' => 'Korean',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for country data to improve performance.
    |
    */
    'cache' => [
        'enabled' => env('COUNTRY_CODE_CACHE_ENABLED', true),
        'ttl' => env('COUNTRY_CODE_CACHE_TTL', 86400), // 24 hours
        'prefix' => 'country_code_',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the API endpoints provided by this package.
    |
    */
    'api' => [
        'enabled' => env('COUNTRY_CODE_API_ENABLED', true),
        'prefix' => 'api/countries',
        'rate_limit' => env('COUNTRY_CODE_API_RATE_LIMIT', 60), // requests per minute
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Custom validation rules for country codes and phone numbers.
    |
    */
    'validation' => [
        'phone_format' => env('COUNTRY_CODE_PHONE_FORMAT', 'international'),
        'strict_mode' => env('COUNTRY_CODE_STRICT_MODE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Regional Groupings
    |--------------------------------------------------------------------------
    |
    | Define custom regional groupings for countries.
    |
    */
    'regions' => [
        'EU' => [
            'name' => 'European Union',
            'countries' => [
                'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR',
                'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
                'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE'
            ],
        ],
        'NAFTA' => [
            'name' => 'North American Free Trade Agreement',
            'countries' => ['CA', 'MX', 'US'],
        ],
        'ASEAN' => [
            'name' => 'Association of Southeast Asian Nations',
            'countries' => [
                'BN', 'KH', 'ID', 'LA', 'MY', 'MM', 'PH', 'SG', 'TH', 'VN'
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Phone Number Formats
    |--------------------------------------------------------------------------
    |
    | Custom phone number formats for specific countries.
    |
    */
    'phone_formats' => [
        'US' => [
            'format' => '+1 (###) ###-####',
            'example' => '+1 (555) 123-4567',
        ],
        'GB' => [
            'format' => '+44 #### ######',
            'example' => '+44 7700 900000',
        ],
        'DE' => [
            'format' => '+49 ### #######',
            'example' => '+49 30 12345678',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Database settings for storing country data.
    |
    */
    'database' => [
        'table_name' => 'countries',
        'connection' => env('COUNTRY_CODE_DB_CONNECTION', null),
    ],
]; 