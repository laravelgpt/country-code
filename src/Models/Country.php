<?php

namespace Laravel\CountryCode\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'iso_alpha2',
        'iso_alpha3',
        'iso_numeric',
        'phone_code',
        'flag_emoji',
        'continent',
        'region',
        'sub_region',
        'capital',
        'currency_code',
        'currency_name',
        'currency_symbol',
        'timezone',
        'languages',
        'population',
        'area_km2',
        'gdp_usd',
        'internet_tld',
        'driving_side',
        'calling_code',
        'postal_code_format',
        'postal_code_regex',
        'geonames_id',
        'fips_code',
        'un_member',
        'independent',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'languages' => 'array',
        'population' => 'integer',
        'area_km2' => 'float',
        'gdp_usd' => 'float',
        'un_member' => 'boolean',
        'independent' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the phone code with plus sign.
     */
    public function getFormattedPhoneCodeAttribute(): string
    {
        return '+' . $this->phone_code;
    }

    /**
     * Get the flag emoji as HTML entity.
     */
    public function getFlagHtmlAttribute(): string
    {
        return '&#x' . bin2hex(mb_convert_encoding($this->flag_emoji, 'UTF-32BE', 'UTF-8')) . ';';
    }

    /**
     * Get the country name in a specific language.
     */
    public function getNameInLanguage(string $language = 'en'): string
    {
        // For now, return the default name
        // In a full implementation, this would use translations
        return $this->name;
    }

    /**
     * Check if the country is in a specific region.
     */
    public function isInRegion(string $region): bool
    {
        return strtolower($this->region) === strtolower($region);
    }

    /**
     * Check if the country is in a specific continent.
     */
    public function isInContinent(string $continent): bool
    {
        return strtolower($this->continent) === strtolower($continent);
    }

    /**
     * Get the phone number format for this country.
     */
    public function getPhoneFormat(): string
    {
        $formats = config('country-code.phone_formats', []);
        
        return $formats[$this->iso_alpha2]['format'] ?? '+## ### ### ####';
    }

    /**
     * Get the phone number example for this country.
     */
    public function getPhoneExample(): string
    {
        $formats = config('country-code.phone_formats', []);
        
        return $formats[$this->iso_alpha2]['example'] ?? $this->formatted_phone_code . ' 123 456 7890';
    }

    /**
     * Scope a query to only include countries in a specific continent.
     */
    public function scopeInContinent($query, string $continent)
    {
        return $query->where('continent', $continent);
    }

    /**
     * Scope a query to only include countries in a specific region.
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Scope a query to only include UN member countries.
     */
    public function scopeUnMembers($query)
    {
        return $query->where('un_member', true);
    }

    /**
     * Scope a query to only include independent countries.
     */
    public function scopeIndependent($query)
    {
        return $query->where('independent', true);
    }

    /**
     * Scope a query to search countries by name.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('iso_alpha2', 'like', "%{$search}%")
                    ->orWhere('iso_alpha3', 'like', "%{$search}%");
    }

    /**
     * Get countries that share the same phone code.
     */
    public function scopeByPhoneCode($query, string $phoneCode)
    {
        return $query->where('phone_code', $phoneCode);
    }

    /**
     * Get countries by ISO code.
     */
    public function scopeByIso($query, string $iso)
    {
        return $query->where('iso_alpha2', $iso)
                    ->orWhere('iso_alpha3', $iso);
    }

    /**
     * Get the country's neighbors (countries in the same region).
     */
    public function neighbors()
    {
        return $this->hasMany(Country::class, 'region', 'region')
                    ->where('id', '!=', $this->id);
    }

    /**
     * Get the country's regional partners.
     */
    public function regionalPartners()
    {
        return $this->belongsToMany(Country::class, 'country_regions', 'country_id', 'partner_id')
                    ->withPivot('region_type')
                    ->withTimestamps();
    }
} 