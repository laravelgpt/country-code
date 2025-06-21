<?php

namespace Laravelgpt\CountryCode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Laravelgpt\CountryCode\Models\Country|null findByIso(string $iso)
 * @method static \Laravelgpt\CountryCode\Models\Country|null findByIso3(string $iso3)
 * @method static \Laravelgpt\CountryCode\Models\Country|null findByPhoneCode(string $phoneCode)
 * @method static \Laravelgpt\CountryCode\Models\Country|null findByName(string $name)
 * @method static \Illuminate\Support\Collection all()
 * @method static \Illuminate\Support\Collection search(string $query)
 * @method static \Laravelgpt\CountryCode\Models\Country|null getDefaultCountry()
 * @method static \Illuminate\Support\Collection getByContinent(string $continent)
 * @method static \Illuminate\Support\Collection getByRegion(string $region)
 * @method static \Illuminate\Support\Collection getByRegionalGroup(string $group)
 * @method static \Illuminate\Support\Collection getUnMembers()
 * @method static \Illuminate\Support\Collection getIndependent()
 * @method static \Illuminate\Support\Collection getContinents()
 * @method static \Illuminate\Support\Collection getRegions()
 * @method static array getPhoneStats()
 * @method static bool validate(string $code)
 *
 * @see \Laravelgpt\CountryCode\Services\CountryCodeService
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