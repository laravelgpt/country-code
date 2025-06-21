@props([
    'type' => 'overview',
    'showCharts' => true,
    'showTables' => true,
    'class' => '',
    'limit' => 10,
    'sortBy' => 'name',
    'sortOrder' => 'asc'
])

<div class="country-stats {{ $class }}" x-data="countryStats()">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Countries</p>
                    <p class="text-2xl font-semibold text-gray-900" x-text="stats.total_countries"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function countryStats() {
    return {
        stats: {
            total_countries: 195,
            continents: [],
            regions: [],
            phone_codes: [],
            top_countries: []
        },
        loading: true,

        async init() {
            await this.loadStats();
            this.loading = false;
        },

        async loadStats() {
            try {
                const response = await fetch('/api/countries/stats');
                const data = await response.json();
                this.stats = data;
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }
    }
}
</script> 