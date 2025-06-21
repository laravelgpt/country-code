<?php

namespace Laravelgpt\CountryCode\View\Components;

use Illuminate\View\Component;
use Laravelgpt\CountryCode\Facades\CountryCode;

class CountrySearch extends Component
{
    public function __construct(
        public string $placeholder = 'Search countries...',
        public bool $showFlag = true,
        public bool $showPhoneCode = false,
        public bool $showRegion = false,
        public bool $showContinent = false,
        public string $class = '',
        public bool $searchable = true,
        public bool $groupBy = false,
        public string $groupByField = 'continent'
    ) {}

    public function render()
    {
        return view('country-code::components.country-search');
    }

    public function getCountries()
    {
        return CountryCode::all();
    }

    public function getSearchUrl()
    {
        return route('countries.search');
    }
} 