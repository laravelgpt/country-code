@props([
    'name' => 'phone',
    'value' => '',
    'country' => null,
    'placeholder' => 'Enter phone number',
    'class' => '',
    'required' => false,
    'disabled' => false,
    'showCountrySelector' => true,
    'validate' => true,
])

@php
    $defaultCountry = $country ?: \Laravel\CountryCode\Facades\CountryCode::getDefaultCountry();
    $phoneCode = $defaultCountry ? $defaultCountry->phone_code : '';
@endphp

<div class="phone-input-container {{ $class }}" x-data="phoneInput()">
    <div class="flex gap-2">
        @if($showCountrySelector)
            <div class="flex-shrink-0">
                <x-country-code::country-selector 
                    name="country_code"
                    :selected="$defaultCountry ? $defaultCountry->iso_alpha2 : null"
                    placeholder="Country"
                    class="w-48"
                    :showFlags="true"
                    :showPhoneCodes="true"
                    @change="onCountryChange"
                />
            </div>
        @endif
        
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 text-sm" x-text="'+' + (selectedPhoneCode || '{{ $phoneCode }}')"></span>
                </div>
                <input 
                    type="tel"
                    name="{{ $name }}"
                    id="{{ $name }}"
                    value="{{ $value }}"
                    placeholder="{{ $placeholder }}"
                    class="form-input w-full pl-12"
                    {{ $required ? 'required' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    x-model="phoneNumber"
                    @input="formatPhoneNumber"
                    @blur="validatePhone"
                >
            </div>
            
            @if($validate)
                <div class="validation-message mt-1 text-sm" x-show="validationMessage" x-text="validationMessage"></div>
            @endif
        </div>
    </div>
    
    <div class="phone-info mt-2 text-xs text-gray-500" x-show="phoneInfo">
        <div x-show="phoneInfo.format">
            Format: <span x-text="phoneInfo.format"></span>
        </div>
        <div x-show="phoneInfo.example">
            Example: <span x-text="phoneInfo.example"></span>
        </div>
    </div>
</div>

<script>
function phoneInput() {
    return {
        phoneNumber: @json($value),
        selectedPhoneCode: @json($phoneCode),
        selectedCountry: @json($defaultCountry ? $defaultCountry->iso_alpha2 : null),
        validationMessage: '',
        phoneInfo: null,
        
        init() {
            this.updatePhoneInfo();
        },
        
        onCountryChange(event) {
            const select = event.target;
            const option = select.options[select.selectedIndex];
            
            this.selectedCountry = select.value;
            this.selectedPhoneCode = option.dataset.phoneCode;
            this.updatePhoneInfo();
            this.formatPhoneNumber();
        },
        
        updatePhoneInfo() {
            if (!this.selectedCountry) {
                this.phoneInfo = null;
                return;
            }
            
            // In a real implementation, you would fetch this from the backend
            // For now, we'll use some common formats
            const formats = {
                'US': { format: '+1 (###) ###-####', example: '+1 (555) 123-4567' },
                'GB': { format: '+44 #### ######', example: '+44 7700 900000' },
                'DE': { format: '+49 ### #######', example: '+49 30 12345678' },
                'FR': { format: '+33 # ## ## ## ##', example: '+33 1 23 45 67 89' },
                'JP': { format: '+81 ##-####-####', example: '+81 90-1234-5678' },
            };
            
            this.phoneInfo = formats[this.selectedCountry] || { 
                format: `+${this.selectedPhoneCode} ### ### ####`, 
                example: `+${this.selectedPhoneCode} 123 456 7890` 
            };
        },
        
        formatPhoneNumber() {
            // Remove all non-digit characters
            let cleaned = this.phoneNumber.replace(/\D/g, '');
            
            // Apply basic formatting based on country
            if (this.selectedCountry === 'US') {
                if (cleaned.length >= 6) {
                    cleaned = cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                } else if (cleaned.length >= 3) {
                    cleaned = cleaned.replace(/(\d{3})(\d{0,3})/, '($1) $2');
                }
            } else if (this.selectedCountry === 'GB') {
                if (cleaned.length >= 7) {
                    cleaned = cleaned.replace(/(\d{4})(\d{6})/, '$1 $2');
                } else if (cleaned.length >= 4) {
                    cleaned = cleaned.replace(/(\d{4})(\d{0,6})/, '$1 $2');
                }
            }
            
            this.phoneNumber = cleaned;
        },
        
        validatePhone() {
            if (!this.phoneNumber) {
                this.validationMessage = '';
                return;
            }
            
            // Remove formatting for validation
            const cleaned = this.phoneNumber.replace(/\D/g, '');
            
            // Basic validation rules
            let isValid = false;
            let message = '';
            
            if (this.selectedCountry === 'US') {
                isValid = cleaned.length === 10;
                message = isValid ? '' : 'US phone numbers must have 10 digits';
            } else if (this.selectedCountry === 'GB') {
                isValid = cleaned.length >= 10 && cleaned.length <= 11;
                message = isValid ? '' : 'UK phone numbers must have 10-11 digits';
            } else {
                // Generic validation
                isValid = cleaned.length >= 7 && cleaned.length <= 15;
                message = isValid ? '' : 'Phone number must be between 7 and 15 digits';
            }
            
            this.validationMessage = message;
            
            // Dispatch validation event
            window.dispatchEvent(new CustomEvent('phone-validation', {
                detail: {
                    isValid,
                    phoneNumber: this.phoneNumber,
                    countryCode: this.selectedCountry,
                    fullNumber: `+${this.selectedPhoneCode} ${this.phoneNumber}`
                }
            }));
        }
    }
}
</script>

<style>
.phone-input-container .validation-message {
    color: #dc2626;
}

.phone-input-container input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
</style> 