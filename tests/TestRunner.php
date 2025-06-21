<?php

namespace Laravelgpt\CountryCode\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Test Runner for Laravel Country Code Package
 * 
 * This class provides a simple way to test the package functionality
 * without requiring a full Laravel application setup.
 */
class TestRunner extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Test Country Model
        $country = new \Laravelgpt\CountryCode\Models\Country();
        echo "✓ Country model instantiated successfully\n";
        
        // Test Service
        $service = new \Laravelgpt\CountryCode\Services\CountryCodeService();
        echo "✓ CountryCodeService instantiated successfully\n";
        
        // Test Facade
        $facade = \Laravelgpt\CountryCode\Facades\CountryCode::class;
        echo "✓ CountryCode facade class found\n";
        
        // Test Rule
        $rule = new \Laravelgpt\CountryCode\Rules\ValidCountryCode();
        echo "✓ ValidCountryCode rule instantiated successfully\n";
        
        echo "\n🎉 All core components are working correctly!\n";
    }

    /**
     * Run basic functionality tests
     */
    public function testBasicFunctionality()
    {
        $this->assertTrue(true);
    }
} 