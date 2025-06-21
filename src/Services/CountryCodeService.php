<?php

namespace Laravel\CountryCode\Services;

use Laravel\CountryCode\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CountryCodeService
{
    /**
     * Get all countries.
     */
    public function all(): Collection
    {
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . 'all';
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () {
                return Country::orderBy('name')->get();
            });
        }
        
        return Country::orderBy('name')->get();
    }

    /**
     * Find a country by ISO code (alpha-2 or alpha-3).
     */
    public function findByIso(string $iso): ?Country
    {
        $iso = strtoupper($iso);
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . "iso_{$iso}";
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () use ($iso) {
                return Country::byIso($iso)->first();
            });
        }
        
        return Country::byIso($iso)->first();
    }

    /**
     * Find countries by phone code.
     */
    public function findByPhoneCode(string $phoneCode): Collection
    {
        $phoneCode = ltrim($phoneCode, '+');
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . "phone_{$phoneCode}";
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () use ($phoneCode) {
                return Country::byPhoneCode($phoneCode)->get();
            });
        }
        
        return Country::byPhoneCode($phoneCode)->get();
    }

    /**
     * Get countries by continent.
     */
    public function getByContinent(string $continent): Collection
    {
        $continent = ucfirst(strtolower($continent));
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . "continent_{$continent}";
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () use ($continent) {
                return Country::inContinent($continent)->orderBy('name')->get();
            });
        }
        
        return Country::inContinent($continent)->orderBy('name')->get();
    }

    /**
     * Get countries by region.
     */
    public function getByRegion(string $region): Collection
    {
        $region = ucfirst(strtolower($region));
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . "region_{$region}";
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () use ($region) {
                return Country::inRegion($region)->orderBy('name')->get();
            });
        }
        
        return Country::inRegion($region)->orderBy('name')->get();
    }

    /**
     * Search countries by name, ISO code, or other criteria.
     */
    public function search(string $query): Collection
    {
        $query = trim($query);
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . "search_" . md5($query);
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () use ($query) {
                return Country::search($query)->orderBy('name')->get();
            });
        }
        
        return Country::search($query)->orderBy('name')->get();
    }

    /**
     * Validate a country code.
     */
    public function validate(string $code): bool
    {
        $code = strtoupper($code);
        
        // Check if it's a valid ISO alpha-2 code
        if (strlen($code) === 2) {
            return Country::where('iso_alpha2', $code)->exists();
        }
        
        // Check if it's a valid ISO alpha-3 code
        if (strlen($code) === 3) {
            return Country::where('iso_alpha3', $code)->exists();
        }
        
        return false;
    }

    /**
     * Get all continents.
     */
    public function getContinents(): Collection
    {
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . 'continents';
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () {
                return Country::distinct()->pluck('continent')->filter()->sort();
            });
        }
        
        return Country::distinct()->pluck('continent')->filter()->sort();
    }

    /**
     * Get all regions.
     */
    public function getRegions(): Collection
    {
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . 'regions';
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () {
                return Country::distinct()->pluck('region')->filter()->sort();
            });
        }
        
        return Country::distinct()->pluck('region')->filter()->sort();
    }

    /**
     * Get countries by custom regional grouping.
     */
    public function getByRegionalGroup(string $group): Collection
    {
        $regions = config('country-code.regions', []);
        
        if (!isset($regions[$group])) {
            return collect();
        }
        
        $countryCodes = $regions[$group]['countries'];
        
        return Country::whereIn('iso_alpha2', $countryCodes)->orderBy('name')->get();
    }

    /**
     * Get phone code statistics.
     */
    public function getPhoneCodeStats(): array
    {
        $cacheKey = config('country-code.cache.prefix', 'country_code_') . 'phone_stats';
        
        if (config('country-code.cache.enabled', true)) {
            return Cache::remember($cacheKey, config('country-code.cache.ttl', 86400), function () {
                return $this->calculatePhoneCodeStats();
            });
        }
        
        return $this->calculatePhoneCodeStats();
    }

    /**
     * Calculate phone code statistics.
     */
    private function calculatePhoneCodeStats(): array
    {
        $stats = DB::table('countries')
            ->select('phone_code', DB::raw('count(*) as country_count'))
            ->groupBy('phone_code')
            ->orderBy('country_count', 'desc')
            ->get();

        return [
            'total_phone_codes' => $stats->count(),
            'most_shared_code' => $stats->first(),
            'least_shared_code' => $stats->last(),
            'average_countries_per_code' => round($stats->avg('country_count'), 2),
            'codes_with_multiple_countries' => $stats->where('country_count', '>', 1)->count(),
        ];
    }

    /**
     * Get the default country.
     */
    public function getDefaultCountry(): ?Country
    {
        $defaultCode = config('country-code.default_country', 'US');
        
        return $this->findByIso($defaultCode);
    }

    /**
     * Clear all cached country data.
     */
    public function clearCache(): void
    {
        $prefix = config('country-code.cache.prefix', 'country_code_');
        
        // Clear all cache keys with the prefix
        $keys = Cache::get($prefix . 'keys', []);
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        Cache::forget($prefix . 'keys');
    }

    /**
     * Get countries with pagination.
     */
    public function paginate(int $perPage = 20): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Country::orderBy('name')->paginate($perPage);
    }

    /**
     * Get countries by status.
     */
    public function getByStatus(string $status): Collection
    {
        return Country::where('status', $status)->orderBy('name')->get();
    }

    /**
     * Get UN member countries.
     */
    public function getUnMembers(): Collection
    {
        return Country::unMembers()->orderBy('name')->get();
    }

    /**
     * Get independent countries.
     */
    public function getIndependent(): Collection
    {
        return Country::independent()->orderBy('name')->get();
    }
} 