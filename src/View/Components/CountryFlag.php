<?php

namespace Laravelgpt\CountryCode\View\Components;

use Illuminate\View\Component;
use Laravelgpt\CountryCode\Facades\CountryCode;

class CountryFlag extends Component
{
    public function __construct(
        public $country = null,
        public ?string $code = null,
        public string $size = 'md',
        public string $class = '',
        public bool $showTooltip = true,
        public bool $clickable = false
    ) {}

    public function render()
    {
        return view('country-code::components.country-flag');
    }
} 