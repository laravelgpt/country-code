@props([
    'selectedCountry' => '',
    'interactive' => true,
    'showTooltips' => true,
    'showLabels' => false,
    'mapType' => 'world',
    'class' => '',
    'width' => 800,
    'height' => 400,
    'theme' => 'light'
])

<div class="country-map {{ $class }}" x-data="countryMap()">
    <div class="relative">
        <!-- Map Container -->
        <div 
            id="country-map-container"
            class="border border-gray-200 rounded-lg overflow-hidden"
            style="width: {{ $width }}px; height: {{ $height }}px;"
        >
            <!-- Map will be rendered here -->
            <div id="map" class="w-full h-full"></div>
        </div>

        <!-- Map Controls -->
        @if($interactive)
        <div class="absolute top-4 right-4 flex flex-col space-y-2">
            <!-- Zoom Controls -->
            <div class="bg-white rounded-lg shadow-lg p-2">
                <button 
                    @click="zoomIn()"
                    class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded"
                    title="Zoom In"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
                <button 
                    @click="zoomOut()"
                    class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded"
                    title="Zoom Out"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                    </svg>
                </button>
            </div>

            <!-- Theme Toggle -->
            <div class="bg-white rounded-lg shadow-lg p-2">
                <button 
                    @click="toggleTheme()"
                    class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded"
                    :title="theme === 'light' ? 'Switch to Dark Theme' : 'Switch to Light Theme'"
                >
                    <svg x-show="theme === 'light'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg x-show="theme === 'dark'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Reset View -->
            <div class="bg-white rounded-lg shadow-lg p-2">
                <button 
                    @click="resetView()"
                    class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded"
                    title="Reset View"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        <!-- Map Legend -->
        <div class="absolute bottom-4 left-4 bg-white rounded-lg shadow-lg p-3">
            <div class="text-sm font-medium text-gray-700 mb-2">Legend</div>
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-blue-500 rounded"></div>
                    <span class="text-xs text-gray-600">Selected</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-gray-300 rounded"></div>
                    <span class="text-xs text-gray-600">Countries</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-green-500 rounded"></div>
                    <span class="text-xs text-gray-600">Highlighted</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Country Info Panel -->
    <div x-show="selectedCountryInfo" class="mt-4 bg-white border border-gray-200 rounded-lg p-4">
        <div class="flex items-center space-x-3">
            <span class="text-3xl" x-text="selectedCountryInfo.flag_emoji"></span>
            <div class="flex-1">
                <h3 class="text-lg font-semibold" x-text="selectedCountryInfo.name"></h3>
                <p class="text-sm text-gray-600">
                    <span x-text="selectedCountryInfo.region"></span> • 
                    <span x-text="selectedCountryInfo.continent"></span>
                </p>
                <p class="text-sm text-gray-600">
                    Phone: +<span x-text="selectedCountryInfo.phone_code"></span>
                </p>
            </div>
            <button 
                @click="clearSelection()"
                class="text-gray-400 hover:text-gray-600"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Map Statistics -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="text-2xl font-bold text-blue-600" x-text="totalCountries"></div>
            <div class="text-sm text-gray-600">Total Countries</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="text-2xl font-bold text-green-600" x-text="selectedCountries.length"></div>
            <div class="text-sm text-gray-600">Selected</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="text-2xl font-bold text-purple-600" x-text="continents.length"></div>
            <div class="text-sm text-gray-600">Continents</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="text-2xl font-bold text-orange-600" x-text="regions.length"></div>
            <div class="text-sm text-gray-600">Regions</div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<script>
function countryMap() {
    return {
        map: null,
        countries: [],
        selectedCountryInfo: null,
        selectedCountries: [],
        totalCountries: 0,
        continents: [],
        regions: [],
        theme: '{{ $theme }}',
        mapType: '{{ $mapType }}',
        interactive: {{ $interactive ? 'true' : 'false' }},
        showTooltips: {{ $showTooltips ? 'true' : 'false' }},
        showLabels: {{ $showLabels ? 'true' : 'false' }},

        async init() {
            await this.loadCountries();
            this.initMap();
            this.setupEventListeners();
        },

        async loadCountries() {
            try {
                const response = await fetch('/api/countries');
                const data = await response.json();
                this.countries = data.data || data;
                this.totalCountries = this.countries.length;
                this.continents = [...new Set(this.countries.map(c => c.continent))];
                this.regions = [...new Set(this.countries.map(c => c.region))];
            } catch (error) {
                console.error('Error loading countries:', error);
            }
        },

        initMap() {
            // Initialize Leaflet map
            this.map = L.map('map', {
                center: [20, 0],
                zoom: 2,
                zoomControl: false,
                attributionControl: false
            });

            // Add tile layer based on theme
            this.updateMapTheme();

            // Add zoom control
            L.control.zoom({
                position: 'bottomright'
            }).addTo(this.map);

            // Add countries to map
            this.addCountriesToMap();
        },

        updateMapTheme() {
            if (this.map.hasLayer(this.map._baseLayer)) {
                this.map.removeLayer(this.map._baseLayer);
            }

            const tileUrl = this.theme === 'dark' 
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

            this.map._baseLayer = L.tileLayer(tileUrl, {
                attribution: '© OpenStreetMap contributors'
            }).addTo(this.map);
        },

        addCountriesToMap() {
            // This is a simplified version - in a real implementation,
            // you would need GeoJSON data for country boundaries
            this.countries.forEach(country => {
                // For demo purposes, we'll create a simple marker
                // In reality, you'd use GeoJSON polygons for country shapes
                const marker = L.marker([this.getRandomLat(), this.getRandomLng()], {
                    title: country.name
                }).addTo(this.map);

                if (this.showTooltips) {
                    marker.bindTooltip(`
                        <div class="text-center">
                            <div class="text-lg">${country.flag_emoji}</div>
                            <div class="font-semibold">${country.name}</div>
                            <div class="text-sm text-gray-600">${country.region}</div>
                        </div>
                    `);
                }

                marker.on('click', () => {
                    this.selectCountry(country);
                });
            });
        },

        getRandomLat() {
            return Math.random() * 180 - 90;
        },

        getRandomLng() {
            return Math.random() * 360 - 180;
        },

        selectCountry(country) {
            this.selectedCountryInfo = country;
            
            if (!this.selectedCountries.find(c => c.iso_alpha2 === country.iso_alpha2)) {
                this.selectedCountries.push(country);
            }

            // Dispatch event
            this.$dispatch('country-selected', { country });
        },

        clearSelection() {
            this.selectedCountryInfo = null;
            this.selectedCountries = [];
            
            // Dispatch event
            this.$dispatch('selection-cleared');
        },

        zoomIn() {
            this.map.zoomIn();
        },

        zoomOut() {
            this.map.zoomOut();
        },

        toggleTheme() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            this.updateMapTheme();
        },

        resetView() {
            this.map.setView([20, 0], 2);
        },

        setupEventListeners() {
            // Listen for country selection from other components
            this.$el.addEventListener('country-selected', (event) => {
                const country = event.detail.country;
                this.selectCountry(country);
            });
        }
    }
}
</script> 