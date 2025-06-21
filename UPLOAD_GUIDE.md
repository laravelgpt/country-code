# 🚀 GitHub Upload Guide - LaravelGPT Country Code v2.0

This guide will help you upload the enhanced LaravelGPT Country Code package v2.0 to GitHub.

## 📋 Prerequisites

### Required Tools
- **Git** (latest version)
- **GitHub Account** with access to `laravelgpt/country-code`
- **GitHub CLI** (optional, for easier management)

### Required Permissions
- **Write access** to the `laravelgpt/country-code` repository
- **Release creation** permissions

## 🔧 Preparation Steps

### 1. Verify Package Structure
Ensure all files are in place:

```bash
# Check package structure
ls -la

# Expected files and directories:
# ✅ composer.json (updated)
# ✅ src/CountryCodeServiceProvider.php (enhanced)
# ✅ config/country-code.php (comprehensive)
# ✅ src/Console/InstallCommand.php (new)
# ✅ src/Console/PublishAssetsCommand.php (new)
# ✅ src/Console/SetupFrontendCommand.php (new)
# ✅ src/View/Components/CountrySearch.php (new)
# ✅ src/View/Components/CountryMap.php (new)
# ✅ src/View/Components/CountryStats.php (new)
# ✅ resources/views/components/ (new templates)
# ✅ .github/workflows/ (CI/CD)
# ✅ CHANGELOG.md (updated)
# ✅ README.md (comprehensive)
```

### 2. Test the Package
Run all tests to ensure everything works:

```bash
# Install dependencies
composer install

# Run tests
composer test

# Check for any linting issues
composer lint
```

### 3. Update Version Numbers
Ensure all version references are updated to `2.0.0`:

- `composer.json` - version field
- `CHANGELOG.md` - latest version
- `README.md` - installation instructions
- Service provider - version constant

## 🚀 Upload Methods

### Method 1: Automated Script (Recommended)

#### For Windows Users:
```bash
# Run the Windows batch script
upload-to-github.bat
```

#### For Linux/Mac Users:
```bash
# Make script executable
chmod +x upload-to-github.sh

# Run the shell script
./upload-to-github.sh
```

### Method 2: Manual Upload

#### Step 1: Initialize Git Repository
```bash
# Initialize git (if not already done)
git init

# Add remote repository
git remote add origin https://github.com/laravelgpt/country-code.git

# Verify remote
git remote -v
```

#### Step 2: Stage and Commit Changes
```bash
# Add all files
git add .

# Commit with descriptive message
git commit -m "feat: release v2.0.0 - Multi-Framework Support

- Add multi-framework frontend support (Blade, Livewire, Vue, React, Alpine.js)
- Add interactive components (CountrySearch, CountryMap, CountryStats)
- Add enhanced installation system with interactive commands
- Add comprehensive configuration system
- Add GitHub Actions CI/CD workflows
- Update documentation and examples
- Add security and performance optimizations"
```

#### Step 3: Push to GitHub
```bash
# Push to main branch
git push -u origin main

# Create and push version tag
git tag -a v2.0.0 -m "Release v2.0.0 - Multi-Framework Support"
git push origin v2.0.0
```

### Method 3: GitHub CLI (Alternative)

```bash
# Install GitHub CLI if not installed
# https://cli.github.com/

# Login to GitHub
gh auth login

# Create repository (if not exists)
gh repo create laravelgpt/country-code --public --description "LaravelGPT Country Code Package - Multi-Framework Support"

# Push code
git add .
git commit -m "feat: release v2.0.0"
git push -u origin main

# Create release
gh release create v2.0.0 --title "v2.0.0 - Multi-Framework Support" --notes-file RELEASE_NOTES_v2.0.0.md
```

## 📝 Release Notes

### Automatic Generation
The upload scripts will automatically generate release notes in `RELEASE_NOTES_v2.0.0.md`.

### Manual Creation
If you need to create release notes manually, use this template:

```markdown
# LaravelGPT Country Code Package v2.0.0

## 🎉 Major Release - Multi-Framework Support

### ✨ New Features

#### Multi-Framework Frontend Support
- **Blade Components** (Enhanced)
- **Livewire Components** (Real-time)
- **Vue.js Components** (Vue 3)
- **React Components** (React 18)
- **Alpine.js Components** (Lightweight)

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
# Basic installation
composer require laravelgpt/country-code

# Interactive installation
php artisan country-code:install --interactive

# Framework-specific installation
php artisan country-code:install --frontend=vue
php artisan country-code:install --frontend=react
php artisan country-code:install --frontend=livewire
```

### 📚 Documentation

- [Complete Documentation](https://github.com/laravelgpt/country-code#readme)
- [API Reference](https://github.com/laravelgpt/country-code/wiki/API)
- [Component Examples](https://github.com/laravelgpt/country-code/wiki/Components)

### 🔧 Breaking Changes

- **Namespace Update**: Changed from `Laravel\CountryCode` to `Laravelgpt\CountryCode`
- **Package Name**: Updated to `laravelgpt/country-code`

### 📦 Installation

```bash
composer require laravelgpt/country-code
php artisan country-code:install --interactive
```

### 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](https://github.com/laravelgpt/country-code/blob/main/CONTRIBUTING.md) for details.

### 📄 License

This package is open-sourced software licensed under the [MIT License](https://github.com/laravelgpt/country-code/blob/main/LICENSE.md).

---

**Made with ❤️ by the LaravelGPT Team**
```

## 🔍 Post-Upload Verification

### 1. Check Repository
- Visit: https://github.com/laravelgpt/country-code
- Verify all files are uploaded correctly
- Check file structure and content

### 2. Check Releases
- Visit: https://github.com/laravelgpt/country-code/releases
- Verify v2.0.0 release is created
- Check release notes are complete

### 3. Check Actions
- Visit: https://github.com/laravelgpt/country-code/actions
- Verify CI/CD workflows are running
- Check for any test failures

### 4. Test Installation
```bash
# Test package installation
composer create-project laravel/laravel test-project
cd test-project
composer require laravelgpt/country-code
php artisan country-code:install --interactive
```

## 🚨 Troubleshooting

### Common Issues

#### 1. Authentication Error
```bash
# Solution: Configure GitHub authentication
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
# Use GitHub CLI or Personal Access Token
```

#### 2. Permission Denied
```bash
# Solution: Check repository permissions
# Ensure you have write access to laravelgpt/country-code
```

#### 3. Tag Already Exists
```bash
# Solution: Delete existing tag
git tag -d v2.0.0
git push origin :refs/tags/v2.0.0
# Then create new tag
```

#### 4. Push Rejected
```bash
# Solution: Force push (use with caution)
git push --force-with-lease origin main
```

### Error Messages

| Error | Solution |
|-------|----------|
| `fatal: remote origin already exists` | `git remote set-url origin https://github.com/laravelgpt/country-code.git` |
| `fatal: refusing to merge unrelated histories` | `git pull origin main --allow-unrelated-histories` |
| `error: failed to push some refs` | `git pull origin main` then `git push origin main` |

## 📊 Success Metrics

After successful upload, verify:

- ✅ **Repository**: All files uploaded correctly
- ✅ **Releases**: v2.0.0 release created with notes
- ✅ **Actions**: CI/CD workflows passing
- ✅ **Installation**: Package installs without errors
- ✅ **Documentation**: README and docs are accessible
- ✅ **Components**: All new components work correctly

## 🎯 Next Steps

### 1. Update Packagist (if applicable)
```bash
# If package is on Packagist, update will be automatic
# Otherwise, submit package to Packagist
```

### 2. Announce Release
- Update social media
- Notify community
- Update documentation sites

### 3. Monitor Feedback
- Watch GitHub issues
- Monitor installation success
- Gather user feedback

### 4. Plan Next Release
- Review feature requests
- Plan v2.1.0 features
- Update roadmap

---

## 📞 Support

If you encounter any issues during the upload process:

1. **Check this guide** for troubleshooting steps
2. **Review GitHub documentation** for git commands
3. **Contact the team** for technical support
4. **Check GitHub issues** for similar problems

---

**Good luck with the release! 🚀** 