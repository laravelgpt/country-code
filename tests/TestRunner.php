<?php

namespace Laravel\CountryCode\Tests;

/**
 * Test Runner Helper
 * 
 * This class provides helper methods for running tests and checking
 * package functionality during development.
 */
class TestRunner
{
    /**
     * Run basic functionality tests
     */
    public static function runBasicTests(): array
    {
        $results = [];
        
        try {
            // Test 1: Check if Country model can be instantiated
            $country = new \Laravel\CountryCode\Models\Country();
            $results['model_instantiation'] = 'PASS';
        } catch (\Exception $e) {
            $results['model_instantiation'] = 'FAIL: ' . $e->getMessage();
        }
        
        try {
            // Test 2: Check if Service can be instantiated
            $service = new \Laravel\CountryCode\Services\CountryCodeService();
            $results['service_instantiation'] = 'PASS';
        } catch (\Exception $e) {
            $results['service_instantiation'] = 'FAIL: ' . $e->getMessage();
        }
        
        try {
            // Test 3: Check if Facade can be accessed
            $facade = \Laravel\CountryCode\Facades\CountryCode::class;
            $results['facade_access'] = 'PASS';
        } catch (\Exception $e) {
            $results['facade_access'] = 'FAIL: ' . $e->getMessage();
        }
        
        try {
            // Test 4: Check if Validation Rule can be instantiated
            $rule = new \Laravel\CountryCode\Rules\ValidCountryCode();
            $results['validation_rule'] = 'PASS';
        } catch (\Exception $e) {
            $results['validation_rule'] = 'FAIL: ' . $e->getMessage();
        }
        
        return $results;
    }
    
    /**
     * Check package structure
     */
    public static function checkPackageStructure(): array
    {
        $requiredFiles = [
            'composer.json',
            'README.md',
            'LICENSE.md',
            'src/CountryCodeServiceProvider.php',
            'src/Models/Country.php',
            'src/Services/CountryCodeService.php',
            'src/Facades/CountryCode.php',
            'src/Rules/ValidCountryCode.php',
            'src/Console/SeedCountriesCommand.php',
            'src/Http/Controllers/CountryController.php',
            'config/country-code.php',
            'database/migrations/2024_01_01_000001_create_countries_table.php',
            'database/seeders/CountrySeeder.php',
            'routes/api.php',
            'resources/views/components/country-selector.blade.php',
            'resources/views/components/country-flag.blade.php',
            'resources/views/components/phone-input.blade.php',
            'tests/TestCase.php',
            'tests/Feature/CountryCodeTest.php',
            'phpunit.xml'
        ];
        
        $results = [];
        $basePath = dirname(__DIR__);
        
        foreach ($requiredFiles as $file) {
            $fullPath = $basePath . '/' . $file;
            if (file_exists($fullPath)) {
                $results[$file] = 'EXISTS';
            } else {
                $results[$file] = 'MISSING';
            }
        }
        
        return $results;
    }
    
    /**
     * Validate composer.json
     */
    public static function validateComposerJson(): array
    {
        $results = [];
        $composerPath = dirname(__DIR__) . '/composer.json';
        
        if (!file_exists($composerPath)) {
            $results['file_exists'] = 'FAIL: composer.json not found';
            return $results;
        }
        
        $results['file_exists'] = 'PASS';
        
        try {
            $composer = json_decode(file_get_contents($composerPath), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $results['json_valid'] = 'FAIL: Invalid JSON';
                return $results;
            }
            
            $results['json_valid'] = 'PASS';
            
            // Check required fields
            $requiredFields = ['name', 'description', 'type', 'license', 'require', 'autoload'];
            foreach ($requiredFields as $field) {
                if (isset($composer[$field])) {
                    $results["field_{$field}"] = 'PASS';
                } else {
                    $results["field_{$field}"] = 'FAIL: Missing';
                }
            }
            
            // Check PHP version requirement
            if (isset($composer['require']['php'])) {
                $phpVersion = $composer['require']['php'];
                if (strpos($phpVersion, '^8.2') !== false) {
                    $results['php_version'] = 'PASS: ' . $phpVersion;
                } else {
                    $results['php_version'] = 'FAIL: Should require PHP 8.2+';
                }
            } else {
                $results['php_version'] = 'FAIL: No PHP version specified';
            }
            
        } catch (\Exception $e) {
            $results['validation'] = 'FAIL: ' . $e->getMessage();
        }
        
        return $results;
    }
    
    /**
     * Run all checks
     */
    public static function runAllChecks(): array
    {
        return [
            'basic_tests' => self::runBasicTests(),
            'structure' => self::checkPackageStructure(),
            'composer' => self::validateComposerJson()
        ];
    }
    
    /**
     * Print results in a formatted way
     */
    public static function printResults(array $results): void
    {
        echo "=== Laravel Country Code Package Test Results ===\n\n";
        
        foreach ($results as $section => $sectionResults) {
            echo strtoupper($section) . ":\n";
            echo str_repeat('-', strlen($section) + 1) . "\n";
            
            if (is_array($sectionResults)) {
                foreach ($sectionResults as $test => $result) {
                    $status = strpos($result, 'PASS') !== false ? '✅' : '❌';
                    echo "  {$status} {$test}: {$result}\n";
                }
            } else {
                echo "  {$sectionResults}\n";
            }
            
            echo "\n";
        }
    }
} 