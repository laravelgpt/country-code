#!/bin/bash

# LaravelGPT Country Code Package v2.0 GitHub Upload Script
# This script uploads the enhanced package to GitHub

set -e

echo "🚀 LaravelGPT Country Code Package v2.0 GitHub Upload"
echo "=================================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
REPO_URL="https://github.com/laravelgpt/country-code.git"
VERSION="2.0.0"
BRANCH="main"

# Function to print colored output
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Check if git is installed
if ! command -v git &> /dev/null; then
    print_error "Git is not installed. Please install git first."
    exit 1
fi

# Check if we're in a git repository
if [ ! -d ".git" ]; then
    print_error "Not in a git repository. Please run this script from the package root directory."
    exit 1
fi

# Check current branch
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "$BRANCH" ]; then
    print_warning "Current branch is $CURRENT_BRANCH, but we're uploading to $BRANCH"
    read -p "Do you want to continue? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_info "Upload cancelled."
        exit 0
    fi
fi

# Check for uncommitted changes
if [ -n "$(git status --porcelain)" ]; then
    print_warning "There are uncommitted changes in your repository."
    git status --short
    read -p "Do you want to commit these changes before uploading? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        print_info "Committing changes..."
        git add .
        git commit -m "feat: prepare for v$VERSION release"
    else
        print_error "Please commit or stash your changes before uploading."
        exit 1
    fi
fi

# Check if remote repository exists
if ! git remote get-url origin &> /dev/null; then
    print_info "Adding remote repository..."
    git remote add origin $REPO_URL
fi

# Verify remote URL
REMOTE_URL=$(git remote get-url origin)
if [[ "$REMOTE_URL" != *"laravelgpt/country-code"* ]]; then
    print_warning "Remote URL doesn't match expected repository: $REMOTE_URL"
    read -p "Do you want to update the remote URL? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git remote set-url origin $REPO_URL
        print_status "Remote URL updated."
    fi
fi

# Create version tag
print_info "Creating version tag v$VERSION..."
if git tag -l | grep -q "v$VERSION"; then
    print_warning "Tag v$VERSION already exists."
    read -p "Do you want to delete and recreate it? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git tag -d "v$VERSION"
        git push origin ":refs/tags/v$VERSION" 2>/dev/null || true
    else
        print_info "Using existing tag."
    fi
fi

# Create new tag
git tag -a "v$VERSION" -m "Release v$VERSION - Multi-Framework Support"

# Push to GitHub
print_info "Pushing to GitHub..."
print_info "Pushing branch $BRANCH..."
git push origin $BRANCH

print_info "Pushing tag v$VERSION..."
git push origin "v$VERSION"

# Create release notes
print_info "Creating release notes..."
RELEASE_NOTES=$(cat <<EOF
# LaravelGPT Country Code Package v$VERSION

## 🎉 Major Release - Multi-Framework Support

### ✨ New Features

#### Multi-Framework Frontend Support
- **Blade Components** (Enhanced)
- **Livewire Components** (Real-time)
- **Vue.js Components** (Vue 3)
- **React Components** (React 18)
- **Alpine.js Components** (Lightweight)

#### New Interactive Components
- \`CountrySearch\` - Advanced search with filters and autocomplete
- \`CountryMap\` - Interactive maps with Leaflet.js
- \`CountryStats\` - Statistics dashboard with charts and exports

#### Enhanced Installation System
- Interactive installation command: \`php artisan country-code:install --interactive\`
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

\`\`\`bash
# Basic installation
composer require laravelgpt/country-code

# Interactive installation
php artisan country-code:install --interactive

# Framework-specific installation
php artisan country-code:install --frontend=vue
php artisan country-code:install --frontend=react
php artisan country-code:install --frontend=livewire
\`\`\`

### 📚 Documentation

- [Complete Documentation](https://github.com/laravelgpt/country-code#readme)
- [API Reference](https://github.com/laravelgpt/country-code/wiki/API)
- [Component Examples](https://github.com/laravelgpt/country-code/wiki/Components)

### 🔧 Breaking Changes

- **Namespace Update**: Changed from \`Laravel\\CountryCode\` to \`Laravelgpt\\CountryCode\`
- **Package Name**: Updated to \`laravelgpt/country-code\`

### 📦 Installation

\`\`\`bash
composer require laravelgpt/country-code
php artisan country-code:install --interactive
\`\`\`

### 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](https://github.com/laravelgpt/country-code/blob/main/CONTRIBUTING.md) for details.

### 📄 License

This package is open-sourced software licensed under the [MIT License](https://github.com/laravelgpt/country-code/blob/main/LICENSE.md).

---

**Made with ❤️ by the LaravelGPT Team**
EOF
)

# Save release notes to file
echo "$RELEASE_NOTES" > "RELEASE_NOTES_v$VERSION.md"
print_status "Release notes saved to RELEASE_NOTES_v$VERSION.md"

# Summary
echo
echo "🎉 Upload Summary"
echo "================"
print_status "Repository: $REPO_URL"
print_status "Version: v$VERSION"
print_status "Branch: $BRANCH"
print_status "Tag: v$VERSION"
print_status "Release notes: RELEASE_NOTES_v$VERSION.md"

echo
print_info "Next steps:"
echo "1. Go to https://github.com/laravelgpt/country-code/releases"
echo "2. Edit the v$VERSION release"
echo "3. Copy content from RELEASE_NOTES_v$VERSION.md"
echo "4. Publish the release"

echo
print_status "Upload completed successfully! 🚀" 