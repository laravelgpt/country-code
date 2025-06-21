@props([
    'placeholder' => 'Search countries...',
    'showFlag' => true,
    'showPhoneCode' => false,
    'showRegion' => false,
    'showContinent' => false,
    'class' => '',
    'searchable' => true,
    'groupBy' => false,
    'groupByField' => 'continent'
])

<div class="country-search {{ $class }}" x-data="countrySearch()">
    <div class="relative">
        <!-- Search Input -->
        <div class="relative">
            <input 
                type="text" 
                x-model="searchQuery"
                @input="searchCountries()"
                placeholder="{{ $placeholder }}"
                class="w-full px-4 py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-blue-500': searchQuery.length > 0 }"
            >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <button 
                    x-show="searchQuery.length > 0"
                    @click="clearSearch()"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Results -->
        <div 
            x-show="showResults && (searchResults.length > 0 || searchQuery.length > 0)"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-96 overflow-y-auto"
        >
            <!-- Loading State -->
            <div x-show="loading" class="p-4 text-center text-gray-500">
                <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-2">Searching...</span>
            </div>

            <!-- No Results -->
            <div x-show="!loading && searchQuery.length > 0 && searchResults.length === 0" class="p-4 text-center text-gray-500">
                No countries found for "<span x-text="searchQuery"></span>"
            </div>

            <!-- Results List -->
            <div x-show="!loading && searchResults.length > 0" class="py-2">
                <template x-for="country in searchResults" :key="country.iso_alpha2">
                    <div 
                        @click="selectCountry(country)"
                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center space-x-3"
                        :class="{ 'bg-blue-50': selectedCountry?.iso_alpha2 === country.iso_alpha2 }"
                    >
                        @if($showFlag)
                        <div class="flex-shrink-0">
                            <span class="text-lg" x-text="country.flag_emoji"></span>
                        </div>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900" x-text="country.name"></div>
                            @if($showRegion || $showContinent)
                            <div class="text-xs text-gray-500">
                                <span x-show="{{ $showRegion ? 'true' : 'false' }}" x-text="country.region"></span>
                                <span x-show="{{ $showRegion && $showContinent ? 'true' : 'false' }}"> • </span>
                                <span x-show="{{ $showContinent ? 'true' : 'false' }}" x-text="country.continent"></span>
                            </div>
                            @endif
                        </div>
                        
                        @if($showPhoneCode)
                        <div class="flex-shrink-0 text-xs text-gray-500">
                            +<span x-text="country.phone_code"></span>
                        </div>
                        @endif
                    </div>
                </template>
            </div>

            <!-- Quick Filters -->
            <div x-show="!loading && searchQuery.length === 0" class="border-t border-gray-200 p-3">
                <div class="text-xs font-medium text-gray-700 mb-2">Quick Filters:</div>
                <div class="flex flex-wrap gap-2">
                    <button 
                        @click="filterByContinent('Europe')"
                        class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded hover:bg-blue-200"
                    >
                        Europe
                    </button>
                    <button 
                        @click="filterByContinent('Asia')"
                        class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded hover:bg-green-200"
                    >
                        Asia
                    </button>
                    <button 
                        @click="filterByContinent('Americas')"
                        class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded hover:bg-red-200"
                    >
                        Americas
                    </button>
                    <button 
                        @click="filterByContinent('Africa')"
                        class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200"
                    >
                        Africa
                    </button>
                    <button 
                        @click="filterByContinent('Oceania')"
                        class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded hover:bg-purple-200"
                    >
                        Oceania
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Selected Country Display -->
    <div x-show="selectedCountry" class="mt-3 p-3 bg-gray-50 rounded-lg">
        <div class="flex items-center space-x-3">
            <span class="text-2xl" x-text="selectedCountry.flag_emoji"></span>
            <div>
                <div class="font-medium" x-text="selectedCountry.name"></div>
                <div class="text-sm text-gray-500">
                    <span x-text="selectedCountry.region"></span> • <span x-text="selectedCountry.continent"></span>
                    @if($showPhoneCode)
                    • +<span x-text="selectedCountry.phone_code"></span>
                    @endif
                </div>
            </div>
            <button 
                @click="clearSelection()"
                class="ml-auto text-gray-400 hover:text-gray-600"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
function countrySearch() {
    return {
        searchQuery: '',
        searchResults: [],
        selectedCountry: null,
        showResults: false,
        loading: false,
        debounceTimer: null,

        init() {
            this.$watch('searchQuery', (value) => {
                if (value.length > 0) {
                    this.showResults = true;
                } else {
                    this.showResults = false;
                    this.searchResults = [];
                }
            });
        },

        async searchCountries() {
            clearTimeout(this.debounceTimer);
            
            this.debounceTimer = setTimeout(async () => {
                if (this.searchQuery.length < 2) {
                    this.searchResults = [];
                    return;
                }

                this.loading = true;
                
                try {
                    const response = await fetch(`/api/countries/search?q=${encodeURIComponent(this.searchQuery)}`);
                    const data = await response.json();
                    this.searchResults = data.data || data;
                } catch (error) {
                    console.error('Search error:', error);
                    this.searchResults = [];
                } finally {
                    this.loading = false;
                }
            }, 300);
        },

        selectCountry(country) {
            this.selectedCountry = country;
            this.searchQuery = country.name;
            this.showResults = false;
            
            // Dispatch event
            this.$dispatch('country-selected', { country });
        },

        clearSearch() {
            this.searchQuery = '';
            this.searchResults = [];
            this.showResults = false;
        },

        clearSelection() {
            this.selectedCountry = null;
            this.searchQuery = '';
            this.searchResults = [];
            this.showResults = false;
            
            // Dispatch event
            this.$dispatch('country-cleared');
        },

        async filterByContinent(continent) {
            this.loading = true;
            
            try {
                const response = await fetch(`/api/countries/continent/${encodeURIComponent(continent)}`);
                const data = await response.json();
                this.searchResults = data.data || data;
                this.searchQuery = continent;
                this.showResults = true;
            } catch (error) {
                console.error('Filter error:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script> 