@echo off
setlocal enabledelayedexpansion

REM LaravelGPT Country Code Package v2.0 GitHub Upload Script
REM This script uploads the enhanced package to GitHub

echo 🚀 LaravelGPT Country Code Package v2.0 GitHub Upload
echo ==================================================

REM Configuration
set REPO_URL=https://github.com/laravelgpt/country-code.git
set VERSION=2.0.0
set BRANCH=main

REM Check if git is installed
git --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Git is not installed. Please install git first.
    exit /b 1
)

REM Check if we're in a git repository
if not exist ".git" (
    echo ❌ Not in a git repository. Please run this script from the package root directory.
    exit /b 1
)

REM Check current branch
for /f "tokens=*" %%i in ('git branch --show-current') do set CURRENT_BRANCH=%%i
if not "%CURRENT_BRANCH%"=="%BRANCH%" (
    echo ⚠️  Current branch is %CURRENT_BRANCH%, but we're uploading to %BRANCH%
    set /p CONTINUE="Do you want to continue? (y/N): "
    if /i not "!CONTINUE!"=="y" (
        echo ℹ️  Upload cancelled.
        exit /b 0
    )
)

REM Check for uncommitted changes
git status --porcelain >nul 2>&1
if not errorlevel 1 (
    echo ⚠️  There are uncommitted changes in your repository.
    git status --short
    set /p COMMIT="Do you want to commit these changes before uploading? (y/N): "
    if /i "!COMMIT!"=="y" (
        echo ℹ️  Committing changes...
        git add .
        git commit -m "feat: prepare for v%VERSION% release"
    ) else (
        echo ❌ Please commit or stash your changes before uploading.
        exit /b 1
    )
)

REM Check if remote repository exists
git remote get-url origin >nul 2>&1
if errorlevel 1 (
    echo ℹ️  Adding remote repository...
    git remote add origin %REPO_URL%
)

REM Verify remote URL
for /f "tokens=*" %%i in ('git remote get-url origin') do set REMOTE_URL=%%i
echo !REMOTE_URL! | findstr /i "laravelgpt/country-code" >nul
if errorlevel 1 (
    echo ⚠️  Remote URL doesn't match expected repository: !REMOTE_URL!
    set /p UPDATE="Do you want to update the remote URL? (y/N): "
    if /i "!UPDATE!"=="y" (
        git remote set-url origin %REPO_URL%
        echo ✅ Remote URL updated.
    )
)

REM Create version tag
echo ℹ️  Creating version tag v%VERSION%...
git tag -l | findstr "v%VERSION%" >nul
if not errorlevel 1 (
    echo ⚠️  Tag v%VERSION% already exists.
    set /p RECREATE="Do you want to delete and recreate it? (y/N): "
    if /i "!RECREATE!"=="y" (
        git tag -d "v%VERSION%"
        git push origin ":refs/tags/v%VERSION%" 2>nul
    ) else (
        echo ℹ️  Using existing tag.
    )
)

REM Create new tag
git tag -a "v%VERSION%" -m "Release v%VERSION% - Multi-Framework Support"

REM Push to GitHub
echo ℹ️  Pushing to GitHub...
echo ℹ️  Pushing branch %BRANCH%...
git push origin %BRANCH%

echo ℹ️  Pushing tag v%VERSION%...
git push origin "v%VERSION%"

REM Create release notes
echo ℹ️  Creating release notes...
(
echo # LaravelGPT Country Code Package v%VERSION%
echo.
echo ## 🎉 Major Release - Multi-Framework Support
echo.
echo ### ✨ New Features
echo.
echo #### Multi-Framework Frontend Support
echo - **Blade Components** ^(Enhanced^)
echo - **Livewire Components** ^(Real-time^)
echo - **Vue.js Components** ^(Vue 3^)
echo - **React Components** ^(React 18^)
echo - **Alpine.js Components** ^(Lightweight^)
echo.
echo #### New Interactive Components
echo - `CountrySearch` - Advanced search with filters and autocomplete
echo - `CountryMap` - Interactive maps with Leaflet.js
echo - `CountryStats` - Statistics dashboard with charts and exports
echo.
echo #### Enhanced Installation System
echo - Interactive installation command: `php artisan country-code:install --interactive`
echo - Framework-specific installation options
echo - Asset publishing commands
echo - Frontend setup commands
echo.
echo #### Advanced Features
echo - Interactive country maps with visual selection
echo - Statistics dashboard with charts and export functionality
echo - Regional groupings ^(EU, G7, G20, ASEAN, NAFTA^)
echo - Multi-language support ^(12+ languages^)
echo - API rate limiting and caching
echo - Export functionality ^(JSON, CSV, PDF^)
echo.
echo ### 🚀 Quick Installation
echo.
echo ```bash
echo # Basic installation
echo composer require laravelgpt/country-code
echo.
echo # Interactive installation
echo php artisan country-code:install --interactive
echo.
echo # Framework-specific installation
echo php artisan country-code:install --frontend=vue
echo php artisan country-code:install --frontend=react
echo php artisan country-code:install --frontend=livewire
echo ```
echo.
echo ### 📚 Documentation
echo.
echo - [Complete Documentation](https://github.com/laravelgpt/country-code#readme^)
echo - [API Reference](https://github.com/laravelgpt/country-code/wiki/API^)
echo - [Component Examples](https://github.com/laravelgpt/country-code/wiki/Components^)
echo.
echo ### 🔧 Breaking Changes
echo.
echo - **Namespace Update**: Changed from `Laravel\\CountryCode` to `Laravelgpt\\CountryCode`
echo - **Package Name**: Updated to `laravelgpt/country-code`
echo.
echo ### 📦 Installation
echo.
echo ```bash
echo composer require laravelgpt/country-code
echo php artisan country-code:install --interactive
echo ```
echo.
echo ### 🤝 Contributing
echo.
echo We welcome contributions! Please see our [Contributing Guide](https://github.com/laravelgpt/country-code/blob/main/CONTRIBUTING.md^) for details.
echo.
echo ### 📄 License
echo.
echo This package is open-sourced software licensed under the [MIT License](https://github.com/laravelgpt/country-code/blob/main/LICENSE.md^).
echo.
echo ---
echo.
echo **Made with ❤️ by the LaravelGPT Team**
) > "RELEASE_NOTES_v%VERSION%.md"

echo ✅ Release notes saved to RELEASE_NOTES_v%VERSION%.md

REM Summary
echo.
echo 🎉 Upload Summary
echo ================
echo ✅ Repository: %REPO_URL%
echo ✅ Version: v%VERSION%
echo ✅ Branch: %BRANCH%
echo ✅ Tag: v%VERSION%
echo ✅ Release notes: RELEASE_NOTES_v%VERSION%.md

echo.
echo ℹ️  Next steps:
echo 1. Go to https://github.com/laravelgpt/country-code/releases
echo 2. Edit the v%VERSION% release
echo 3. Copy content from RELEASE_NOTES_v%VERSION%.md
echo 4. Publish the release

echo.
echo ✅ Upload completed successfully! 🚀

pause 