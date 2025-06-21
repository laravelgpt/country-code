# LaravelGPT Country Code Package v2.0.0

## 🎉 Major Release - Multi-Framework Support

### ✨ New Features

#### Multi-Framework Frontend Support
- **Blade Components** (Enhanced - No additional dependencies)
- **Livewire Components** (Real-time - Requires `livewire/livewire`)
- **Vue.js Components** (Vue 3 - Requires `vue` npm package)
- **React Components** (React 18 - Requires `react` npm package)
- **Alpine.js Components** (Lightweight - Requires `alpinejs` npm package)

#### New Interactive Components
- `CountrySearch` - Advanced search with filters and autocomplete
- `CountryMap` - Interactive maps with Leaflet.js
- `CountryStats` - Statistics dashboard with charts and exports

#### Enhanced Installation System
- Interactive installation command: `php artisan country-code:install --interactive`
- Framework-specific installation options
- Asset publishing commands
- Frontend setup commands

#### Advanced Features
- Interactive country maps with visual selection
- Statistics dashboard with charts and export functionality
- Regional groupings (EU, G7, G20, ASEAN, NAFTA)
- Multi-language support (12+ languages)
- API rate limiting and caching
- Export functionality (JSON, CSV, PDF)

### 🚀 Quick Installation

```bash
# Basic installation (Blade only - no additional dependencies)
composer require laravelgpt/country-code
php artisan country-code:install

# Interactive installation
php artisan country-code:install --interactive

# Framework-specific installation
php artisan country-code:install --frontend=blade    # No dependencies
php artisan country-code:install --frontend=livewire # Requires livewire/livewire
php artisan country-code:install --frontend=vue      # Requires vue npm package
php artisan country-code:install --frontend=react    # Requires react npm package
php artisan country-code:install --frontend=alpine   # Requires alpinejs npm package
```

### 📦 Frontend Dependencies

The package includes a `package.json` file with recommended frontend dependencies:

```bash
# Install all frontend dependencies (optional)
npm install

# Or install specific frameworks as needed:
npm install alpinejs        # For Alpine.js components
npm install vue             # For Vue.js components
npm install react react-dom # For React components
npm install leaflet         # For interactive maps
npm install chart.js        # For statistics charts
```

### 📚 Documentation

- [Complete Documentation](https://github.com/laravelgpt/country-code#readme)
- [API Reference](https://github.com/laravelgpt/country-code/wiki/API)
- [Component Examples](https://github.com/laravelgpt/country-code/wiki/Components)

### 🔧 Breaking Changes

- **Namespace Update**: Changed from `Laravel\CountryCode` to `Laravelgpt\CountryCode`
- **Package Name**: Updated to `laravelgpt/country-code`
- **Frontend Dependencies**: Now properly separated between Composer and npm packages

### 🐛 Bug Fixes

- **Fixed**: Invalid `alpinejs` dependency in composer.json (Alpine.js is an npm package, not a Composer package)
- **Added**: Proper `package.json` file for frontend dependencies
- **Updated**: Documentation to clarify dependency requirements for each framework

### 📦 Installation

```bash
# Basic installation (Blade components only)
composer require laravelgpt/country-code
php artisan country-code:install

# With frontend frameworks
npm install  # Install frontend dependencies
php artisan country-code:install --interactive
```

### 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](https://github.com/laravelgpt/country-code/blob/main/CONTRIBUTING.md) for details.

### 📄 License

This package is open-sourced software licensed under the [MIT License](https://github.com/laravelgpt/country-code/blob/main/LICENSE.md).

---

**Made with ❤️ by the LaravelGPT Team**
