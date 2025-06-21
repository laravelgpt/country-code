<?php

namespace Laravelgpt\CountryCode\View\Components;

use Illuminate\View\Component;
use Laravelgpt\CountryCode\Facades\CountryCode;

class CountryMap extends Component
{
    public function __construct(
        public string $selectedCountry = '',
        public bool $interactive = true,
        public bool $showTooltips = true,
        public bool $showLabels = false,
        public string $mapType = 'world', // world, continent, region
        public string $class = '',
        public int $width = 800,
        public int $height = 400,
        public string $theme = 'light' // light, dark
    ) {}

    public function render()
    {
        return view('country-code::components.country-map');
    }

    public function getCountries()
    {
        return CountryCode::all();
    }

    public function getMapData()
    {
        $countries = $this->getCountries();
        
        return $countries->map(function ($country) {
            return [
                'code' => $country->iso_alpha2,
                'name' => $country->name,
                'flag' => $country->flag_emoji,
                'region' => $country->region,
                'continent' => $country->continent,
            ];
        })->toArray();
    }
} 