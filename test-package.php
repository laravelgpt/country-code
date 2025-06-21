<?php

/**
 * Laravel Country Code Package - Basic Test Script
 * 
 * This script runs basic checks on the package without requiring
 * a full Laravel environment.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Laravel\CountryCode\Tests\TestRunner;

echo "Running Laravel Country Code Package Tests...\n\n";

try {
    $results = TestRunner::runAllChecks();
    TestRunner::printResults($results);
    
    // Summary
    $totalTests = 0;
    $passedTests = 0;
    
    foreach ($results as $section => $sectionResults) {
        if (is_array($sectionResults)) {
            foreach ($sectionResults as $test => $result) {
                $totalTests++;
                if (strpos($result, 'PASS') !== false || strpos($result, 'EXISTS') !== false) {
                    $passedTests++;
                }
            }
        }
    }
    
    echo "SUMMARY:\n";
    echo "Total tests: {$totalTests}\n";
    echo "Passed: {$passedTests}\n";
    echo "Failed: " . ($totalTests - $passedTests) . "\n";
    echo "Success rate: " . round(($passedTests / $totalTests) * 100, 2) . "%\n\n";
    
    if ($passedTests === $totalTests) {
        echo "🎉 All tests passed! Package is ready for use.\n";
        exit(0);
    } else {
        echo "⚠️  Some tests failed. Please check the results above.\n";
        exit(1);
    }
    
} catch (Exception $e) {
    echo "❌ Error running tests: " . $e->getMessage() . "\n";
    exit(1);
} 