<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Country
    |--------------------------------------------------------------------------
    |
    | The default country to use when no country is specified.
    | This should be a valid ISO 3166-1 alpha-2 code.
    |
    */
    'default_country' => env('COUNTRY_CODE_DEFAULT', 'US'),

    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | List of supported languages for country names and translations.
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
        'ar' => 'Arabic',
        'hi' => 'Hindi',
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
        'prefix' => env('COUNTRY_CODE_CACHE_PREFIX', 'country_code'),
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | API settings for external country data sources.
    |
    */
    'api' => [
        'enabled' => env('COUNTRY_CODE_API_ENABLED', true),
        'rate_limit' => env('COUNTRY_CODE_API_RATE_LIMIT', 100), // requests per minute
        'timeout' => env('COUNTRY_CODE_API_TIMEOUT', 30), // seconds
        'providers' => [
            'restcountries' => [
                'enabled' => true,
                'base_url' => 'https://restcountries.com/v3.1',
                'api_key' => env('RESTCOUNTRIES_API_KEY'),
            ],
            'geonames' => [
                'enabled' => false,
                'base_url' => 'http://api.geonames.org',
                'username' => env('GEONAMES_USERNAME'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend Framework Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for different frontend frameworks.
    |
    */
    'frontend' => [
        'default' => env('COUNTRY_CODE_FRONTEND', 'blade'),
        'frameworks' => [
            'blade' => [
                'enabled' => true,
                'components' => [
                    'country-selector' => true,
                    'country-flag' => true,
                    'phone-input' => true,
                    'country-search' => true,
                    'country-map' => true,
                    'country-stats' => true,
                ],
            ],
            'livewire' => [
                'enabled' => env('COUNTRY_CODE_LIVEWIRE_ENABLED', false),
                'components' => [
                    'country-selector' => true,
                    'country-search' => true,
                    'phone-input' => true,
                    'country-map' => true,
                ],
            ],
            'vue' => [
                'enabled' => env('COUNTRY_CODE_VUE_ENABLED', false),
                'version' => '3',
                'components' => [
                    'country-selector' => true,
                    'country-flag' => true,
                    'phone-input' => true,
                    'country-search' => true,
                ],
            ],
            'react' => [
                'enabled' => env('COUNTRY_CODE_REACT_ENABLED', false),
                'version' => '18',
                'components' => [
                    'country-selector' => true,
                    'country-flag' => true,
                    'phone-input' => true,
                    'country-search' => true,
                ],
            ],
            'alpine' => [
                'enabled' => env('COUNTRY_CODE_ALPINE_ENABLED', false),
                'version' => '3',
                'components' => [
                    'country-selector' => true,
                    'country-flag' => true,
                    'phone-input' => true,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Regional Groupings
    |--------------------------------------------------------------------------
    |
    | Custom regional groupings for countries.
    |
    */
    'regional_groupings' => [
        'eu' => [
            'name' => 'European Union',
            'countries' => [
                'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR',
                'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
                'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE'
            ],
        ],
        'nafta' => [
            'name' => 'North American Free Trade Agreement',
            'countries' => ['CA', 'MX', 'US'],
        ],
        'asean' => [
            'name' => 'Association of Southeast Asian Nations',
            'countries' => [
                'BN', 'KH', 'ID', 'LA', 'MY', 'MM', 'PH', 'SG', 'TH', 'VN'
            ],
        ],
        'g7' => [
            'name' => 'Group of Seven',
            'countries' => ['CA', 'FR', 'DE', 'IT', 'JP', 'GB', 'US'],
        ],
        'g20' => [
            'name' => 'Group of Twenty',
            'countries' => [
                'AR', 'AU', 'BR', 'CA', 'CN', 'FR', 'DE', 'IN', 'ID', 'IT',
                'JP', 'MX', 'RU', 'SA', 'ZA', 'KR', 'TR', 'GB', 'US', 'EU'
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Phone Number Configuration
    |--------------------------------------------------------------------------
    |
    | Phone number formatting and validation settings.
    |
    */
    'phone' => [
        'format' => env('COUNTRY_CODE_PHONE_FORMAT', 'international'),
        'validation' => [
            'enabled' => true,
            'strict' => false,
            'allow_extensions' => true,
        ],
        'display' => [
            'show_country_code' => true,
            'show_flag' => true,
            'show_name' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Flag Configuration
    |--------------------------------------------------------------------------
    |
    | Flag display settings.
    |
    */
    'flags' => [
        'type' => env('COUNTRY_CODE_FLAG_TYPE', 'emoji'), // emoji, svg, png
        'sizes' => [
            'xs' => '16px',
            'sm' => '24px',
            'md' => '32px',
            'lg' => '48px',
            'xl' => '64px',
        ],
        'cdn' => [
            'enabled' => false,
            'base_url' => 'https://flagcdn.com',
            'format' => 'svg',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Database settings for country data.
    |
    */
    'database' => [
        'table_name' => env('COUNTRY_CODE_TABLE_NAME', 'countries'),
        'connection' => env('COUNTRY_CODE_DB_CONNECTION', null),
        'auto_migrate' => env('COUNTRY_CODE_AUTO_MIGRATE', true),
        'auto_seed' => env('COUNTRY_CODE_AUTO_SEED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Security settings for the package.
    |
    */
    'security' => [
        'rate_limiting' => [
            'enabled' => true,
            'max_requests' => 1000,
            'decay_minutes' => 1,
        ],
        'cors' => [
            'enabled' => true,
            'allowed_origins' => ['*'],
            'allowed_methods' => ['GET', 'POST'],
            'allowed_headers' => ['Content-Type', 'Authorization'],
        ],
        'authentication' => [
            'required' => false,
            'guard' => 'web',
            'middleware' => ['auth'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Logging settings for the package.
    |
    */
    'logging' => [
        'enabled' => env('COUNTRY_CODE_LOGGING_ENABLED', true),
        'channel' => env('COUNTRY_CODE_LOG_CHANNEL', 'daily'),
        'level' => env('COUNTRY_CODE_LOG_LEVEL', 'info'),
        'events' => [
            'country_created' => true,
            'country_updated' => true,
            'country_deleted' => true,
            'api_requests' => true,
            'cache_hits' => false,
            'cache_misses' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | Performance optimization settings.
    |
    */
    'performance' => [
        'eager_loading' => true,
        'query_optimization' => true,
        'indexes' => [
            'iso_alpha2' => true,
            'iso_alpha3' => true,
            'phone_code' => true,
            'name' => true,
        ],
        'pagination' => [
            'default_per_page' => 20,
            'max_per_page' => 100,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Customization Configuration
    |--------------------------------------------------------------------------
    |
    | Customization settings for the package.
    |
    */
    'customization' => [
        'views_path' => resource_path('views/vendor/country-code'),
        'assets_path' => resource_path('js/vendor/country-code'),
        'css_path' => resource_path('css/vendor/country-code'),
        'js_path' => resource_path('js/vendor/country-code'),
        'livewire_path' => resource_path('livewire/vendor/country-code'),
        'vue_path' => resource_path('js/vendor/country-code/vue'),
        'react_path' => resource_path('js/vendor/country-code/react'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Configuration
    |--------------------------------------------------------------------------
    |
    | Development and debugging settings.
    |
    */
    'development' => [
        'debug' => env('COUNTRY_CODE_DEBUG', false),
        'profiling' => env('COUNTRY_CODE_PROFILING', false),
        'testing' => [
            'enabled' => env('COUNTRY_CODE_TESTING', false),
            'fake_data' => env('COUNTRY_CODE_FAKE_DATA', false),
        ],
    ],
]; 