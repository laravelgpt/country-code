<?php

namespace Laravel\CountryCode\Tests\Unit;

use Laravel\CountryCode\Tests\TestCase;
use Laravel\CountryCode\Rules\ValidCountryCode;
use Laravel\CountryCode\Database\Seeders\CountrySeeder;

class ValidCountryCodeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $seeder = new CountrySeeder();
        $seeder->run();
    }

    /** @test */
    public function it_validates_valid_alpha2_codes()
    {
        $rule = new ValidCountryCode();
        $fails = false;
        $failMessage = '';

        $rule->validate('country_code', 'US', function ($message) use (&$fails, &$failMessage) {
            $fails = true;
            $failMessage = $message;
        });

        $this->assertFalse($fails, "Validation failed with message: {$failMessage}");
    }

    /** @test */
    public function it_validates_valid_alpha3_codes()
    {
        $rule = new ValidCountryCode();
        $fails = false;
        $failMessage = '';

        $rule->validate('country_code', 'USA', function ($message) use (&$fails, &$failMessage) {
            $fails = true;
            $failMessage = $message;
        });

        $this->assertFalse($fails, "Validation failed with message: {$failMessage}");
    }

    /** @test */
    public function it_rejects_invalid_alpha2_codes()
    {
        $rule = new ValidCountryCode();
        $fails = false;
        $failMessage = '';

        $rule->validate('country_code', 'XX', function ($message) use (&$fails, &$failMessage) {
            $fails = true;
            $failMessage = $message;
        });

        $this->assertTrue($fails);
        $this->assertStringContainsString('must be a valid ISO 3166-1 alpha-2 country code', $failMessage);
    }

    /** @test */
    public function it_rejects_invalid_alpha3_codes()
    {
        $rule = new ValidCountryCode();
        $fails = false;
        $failMessage = '';

        $rule->validate('country_code', 'XXX', function ($message) use (&$fails, &$failMessage) {
            $fails = true;
            $failMessage = $message;
        });

        $this->assertTrue($fails);
        $this->assertStringContainsString('must be a valid ISO 3166-1 alpha-3 country code', $failMessage);
    }

    /** @test */
    public function it_rejects_codes_with_wrong_length()
    {
        $rule = new ValidCountryCode();
        $fails = false;
        $failMessage = '';

        $rule->validate('country_code', 'XXXX', function ($message) use (&$fails, &$failMessage) {
            $fails = true;
            $failMessage = $message;
        });

        $this->assertTrue($fails);
        $this->assertStringContainsString('must be a valid 2 or 3 character country code', $failMessage);
    }

    /** @test */
    public function it_handles_empty_values()
    {
        $rule = new ValidCountryCode();
        $fails = false;

        $rule->validate('country_code', '', function ($message) use (&$fails) {
            $fails = true;
        });

        $this->assertFalse($fails, 'Empty values should not trigger validation failure');
    }

    /** @test */
    public function it_handles_null_values()
    {
        $rule = new ValidCountryCode();
        $fails = false;

        $rule->validate('country_code', null, function ($message) use (&$fails) {
            $fails = true;
        });

        $this->assertFalse($fails, 'Null values should not trigger validation failure');
    }

    /** @test */
    public function it_is_case_insensitive()
    {
        $rule = new ValidCountryCode();
        $fails = false;

        $rule->validate('country_code', 'us', function ($message) use (&$fails) {
            $fails = true;
        });

        $this->assertFalse($fails, 'Lowercase codes should be valid');

        $rule->validate('country_code', 'usa', function ($message) use (&$fails) {
            $fails = true;
        });

        $this->assertFalse($fails, 'Lowercase alpha3 codes should be valid');
    }

    /** @test */
    public function it_validates_multiple_valid_codes()
    {
        $rule = new ValidCountryCode();
        $validCodes = ['US', 'CA', 'GB', 'DE', 'FR', 'JP', 'AU', 'BR', 'IN', 'CN'];

        foreach ($validCodes as $code) {
            $fails = false;
            $rule->validate('country_code', $code, function ($message) use (&$fails) {
                $fails = true;
            });

            $this->assertFalse($fails, "Code {$code} should be valid");
        }
    }

    /** @test */
    public function it_rejects_multiple_invalid_codes()
    {
        $rule = new ValidCountryCode();
        $invalidCodes = ['XX', 'YY', 'ZZ', 'AAA', 'BBB', 'CCC', 'XXXX', 'YYYY'];

        foreach ($invalidCodes as $code) {
            $fails = false;
            $rule->validate('country_code', $code, function ($message) use (&$fails) {
                $fails = true;
            });

            $this->assertTrue($fails, "Code {$code} should be invalid");
        }
    }
} 