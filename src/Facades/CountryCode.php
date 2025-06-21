<?php

namespace Laravel\CountryCode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection all()
 * @method static \Laravel\CountryCode\Models\Country|null findByIso(string $iso)
 * @method static \Illuminate\Support\Collection findByPhoneCode(string $phoneCode)
 * @method static \Illuminate\Support\Collection getByContinent(string $continent)
 * @method static \Illuminate\Support\Collection getByRegion(string $region)
 * @method static \Illuminate\Support\Collection search(string $query)
 * @method static bool validate(string $code)
 * @method static \Illuminate\Support\Collection getContinents()
 * @method static \Illuminate\Support\Collection getRegions()
 * @method static \Illuminate\Support\Collection getByRegionalGroup(string $group)
 * @method static array getPhoneCodeStats()
 * @method static \Laravel\CountryCode\Models\Country|null getDefaultCountry()
 * @method static void clearCache()
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate(int $perPage = 20)
 * @method static \Illuminate\Support\Collection getByStatus(string $status)
 * @method static \Illuminate\Support\Collection getUnMembers()
 * @method static \Illuminate\Support\Collection getIndependent()
 *
 * @see \Laravel\CountryCode\Services\CountryCodeService
 */
class CountryCode extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'country-code';
    }
} 