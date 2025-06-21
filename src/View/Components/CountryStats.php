<?php

namespace Laravelgpt\CountryCode\View\Components;

use Illuminate\View\Component;
use Laravelgpt\CountryCode\Facades\CountryCode;

class CountryStats extends Component
{
    public function __construct(
        public string $type = 'overview', // overview, continent, region, phone
        public bool $showCharts = true,
        public bool $showTables = true,
        public string $class = '',
        public int $limit = 10,
        public string $sortBy = 'name', // name, population, area, phone_code
        public string $sortOrder = 'asc' // asc, desc
    ) {}

    public function render()
    {
        return view('country-code::components.country-stats');
    }

    public function getStats()
    {
        $countries = CountryCode::all();
        
        return [
            'total_countries' => $countries->count(),
            'continents' => $this->getContinentStats($countries),
            'regions' => $this->getRegionStats($countries),
            'phone_codes' => $this->getPhoneCodeStats($countries),
            'top_countries' => $this->getTopCountries($countries),
        ];
    }

    protected function getContinentStats($countries)
    {
        return $countries->groupBy('continent')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->continent,
                    'count' => $group->count(),
                    'percentage' => round(($group->count() / $countries->count()) * 100, 1)
                ];
            })
            ->sortByDesc('count')
            ->values();
    }

    protected function getRegionStats($countries)
    {
        return $countries->groupBy('region')
            ->map(function ($group) use ($countries) {
                return [
                    'name' => $group->first()->region,
                    'count' => $group->count(),
                    'percentage' => round(($group->count() / $countries->count()) * 100, 1)
                ];
            })
            ->sortByDesc('count')
            ->values();
    }

    protected function getPhoneCodeStats($countries)
    {
        return $countries->groupBy('phone_code')
            ->map(function ($group) {
                return [
                    'code' => $group->first()->phone_code,
                    'count' => $group->count(),
                    'countries' => $group->pluck('name')->toArray()
                ];
            })
            ->sortByDesc('count')
            ->values();
    }

    protected function getTopCountries($countries)
    {
        return $countries->take($this->limit)
            ->sortBy($this->sortBy, $this->sortOrder === 'desc')
            ->values();
    }
} 