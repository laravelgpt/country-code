<?php

namespace Laravel\CountryCode\View\Components;

use Illuminate\View\Component;
use Laravel\CountryCode\Facades\CountryCode;

class CountrySelector extends Component
{
    public function __construct(
        public string $name = 'country',
        public ?string $selected = null,
        public string $placeholder = 'Select a country',
        public string $class = '',
        public bool $required = false,
        public bool $disabled = false,
        public bool $searchable = true,
        public bool $showFlags = true,
        public bool $showPhoneCodes = true
    ) {}

    public function render()
    {
        return view('country-code::components.country-selector');
    }
} 