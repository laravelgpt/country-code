<?php

/**
 * Test Package Script
 * 
 * This script can be used to test the Laravel Country Code package
 * without requiring a full Laravel application setup.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Laravelgpt\CountryCode\Tests\TestRunner;

echo "Running Laravel Country Code Package Tests...\n\n";

// Create a test instance and run basic tests
$testRunner = new TestRunner();
$testRunner->setUp();

echo "\n✅ Package test completed successfully!\n"; 