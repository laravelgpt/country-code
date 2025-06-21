@props([
    'country' => null,
    'code' => null,
    'size' => 'md',
    'class' => '',
    'showTooltip' => true,
    'clickable' => false,
])

@php
    $countryData = null;
    
    if ($country) {
        $countryData = is_string($country) ? \Laravel\CountryCode\Facades\CountryCode::findByIso($country) : $country;
    } elseif ($code) {
        $countryData = \Laravel\CountryCode\Facades\CountryCode::findByIso($code);
    }
    
    $sizes = [
        'xs' => 'w-4 h-4 text-xs',
        'sm' => 'w-6 h-6 text-sm',
        'md' => 'w-8 h-8 text-base',
        'lg' => 'w-12 h-12 text-lg',
        'xl' => 'w-16 h-16 text-xl',
        '2xl' => 'w-20 h-20 text-2xl',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

@if($countryData)
    <div 
        class="country-flag inline-flex items-center justify-center {{ $sizeClass }} {{ $class }} {{ $clickable ? 'cursor-pointer hover:scale-110 transition-transform' : '' }}"
        @if($showTooltip)
            title="{{ $countryData->name }}"
        @endif
        @if($clickable)
            onclick="window.dispatchEvent(new CustomEvent('country-flag-clicked', { detail: { country: '{{ $countryData->iso_alpha2 }}', name: '{{ $countryData->name }}' } }))"
        @endif
    >
        <span class="flag-emoji" role="img" aria-label="Flag of {{ $countryData->name }}">
            {{ $countryData->flag_emoji }}
        </span>
    </div>
@else
    <div class="country-flag-placeholder {{ $sizeClass }} {{ $class }} bg-gray-200 rounded flex items-center justify-center">
        <span class="text-gray-400 text-xs">?</span>
    </div>
@endif

<style>
.country-flag {
    border-radius: 4px;
    overflow: hidden;
}

.flag-emoji {
    display: block;
    line-height: 1;
    font-style: normal;
}

.country-flag:hover .flag-emoji {
    filter: brightness(1.1);
}

.country-flag-placeholder {
    border: 1px solid #e5e7eb;
}
</style> 