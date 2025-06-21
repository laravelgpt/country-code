@props([
    'name' => 'country',
    'value' => null,
    'placeholder' => 'Select a country...',
    'class' => '',
    'required' => false,
    'disabled' => false,
    'showFlag' => true,
    'showPhoneCode' => false,
    'groupBy' => null, // 'continent', 'region', or null
    'filterBy' => null, // 'independent', 'un_members', or null
])

@php
    $countries = collect();
    
    if ($groupBy === 'continent') {
        $continents = \Laravelgpt\CountryCode\Facades\CountryCode::getContinents();
        foreach ($continents as $continent) {
            $continentCountries = \Laravelgpt\CountryCode\Facades\CountryCode::getByContinent($continent);
            $countries->put($continent, $continentCountries);
        }
    } elseif ($groupBy === 'region') {
        $regions = \Laravelgpt\CountryCode\Facades\CountryCode::getRegions();
        foreach ($regions as $region) {
            $regionCountries = \Laravelgpt\CountryCode\Facades\CountryCode::getByRegion($region);
            $countries->put($region, $regionCountries);
        }
    } else {
        $allCountries = \Laravelgpt\CountryCode\Facades\CountryCode::all();
        
        if ($filterBy === 'independent') {
            $allCountries = \Laravelgpt\CountryCode\Facades\CountryCode::getIndependent();
        } elseif ($filterBy === 'un_members') {
            $allCountries = \Laravelgpt\CountryCode\Facades\CountryCode::getUnMembers();
        }
        
        $countries = $allCountries;
    }
@endphp

<div class="country-selector {{ $class }}" x-data="countrySelector()">
    <select 
        name="{{ $name }}" 
        id="{{ $name }}"
        class="form-select w-full"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        x-model="selectedCountry"
        @change="onCountryChange"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($countries as $country)
            <option 
                value="{{ $country->iso_alpha2 }}"
                data-phone-code="{{ $country->phone_code }}"
                data-flag="{{ $country->flag_emoji }}"
                {{ $value && $value == $country->iso_alpha2 ? 'selected' : '' }}
            >
                @if($showFlag)
                    {{ $country->flag_emoji }} 
                @endif
                {{ $country->name }}
                @if($showPhoneCode)
                    (+{{ $country->phone_code }})
                @endif
            </option>
        @endforeach
    </select>

    @if($searchable)
        <div class="mt-2">
            <input 
                type="text" 
                placeholder="Search countries..."
                class="form-input w-full text-sm"
                x-model="searchQuery"
                @input="filterCountries"
            >
        </div>
    @endif

    <div class="country-info mt-2 text-sm text-gray-600" x-show="selectedCountryInfo">
        <div x-show="selectedCountryInfo.flag" class="flex items-center gap-2">
            <span x-text="selectedCountryInfo.flag"></span>
            <span x-text="selectedCountryInfo.name"></span>
        </div>
        <div x-show="selectedCountryInfo.phone_code" class="text-xs">
            Phone: +<span x-text="selectedCountryInfo.phone_code"></span>
        </div>
    </div>
</div>

<script>
function countrySelector() {
    return {
        selectedCountry: @json($value),
        searchQuery: '',
        selectedCountryInfo: null,
        
        init() {
            this.updateCountryInfo();
        },
        
        onCountryChange() {
            this.updateCountryInfo();
        },
        
        updateCountryInfo() {
            if (!this.selectedCountry) {
                this.selectedCountryInfo = null;
                return;
            }
            
            const option = this.$el.querySelector(`option[value="${this.selectedCountry}"]`);
            if (option) {
                this.selectedCountryInfo = {
                    name: option.textContent.trim(),
                    flag: option.dataset.flag,
                    phone_code: option.dataset.phoneCode
                };
            }
        },
        
        filterCountries() {
            const options = this.$el.querySelectorAll('option');
            const query = this.searchQuery.toLowerCase();
            
            options.forEach(option => {
                if (option.value === '') return; // Skip placeholder
                
                const text = option.textContent.toLowerCase();
                if (text.includes(query)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        }
    }
}
</script>

<style>
.country-selector select option {
    padding: 8px 12px;
}

.country-selector select option:checked {
    background-color: #3b82f6;
    color: white;
}
</style> 