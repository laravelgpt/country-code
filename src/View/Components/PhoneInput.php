<?php

namespace Laravel\CountryCode\View\Components;

use Illuminate\View\Component;
use Laravel\CountryCode\Facades\CountryCode;

class PhoneInput extends Component
{
    public function __construct(
        public string $name = 'phone',
        public string $value = '',
        public $country = null,
        public string $placeholder = 'Enter phone number',
        public string $class = '',
        public bool $required = false,
        public bool $disabled = false,
        public bool $showCountrySelector = true,
        public bool $validate = true
    ) {}

    public function render()
    {
        return view('country-code::components.phone-input');
    }
} 