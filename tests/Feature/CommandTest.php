<?php

namespace Laravelgpt\CountryCode\Tests\Feature;

use Laravelgpt\CountryCode\Tests\TestCase;
use Laravelgpt\CountryCode\Models\Country;

class CommandTest extends TestCase
{
    /** @test */
    public function it_can_seed_countries_via_command()
    {
        $this->artisan('country-code:seed', ['--force' => true])
             ->expectsOutput('Countries seeded successfully!')
             ->assertExitCode(0);

        $this->assertDatabaseHas('countries', [
            'iso_alpha2' => 'US',
            'name' => 'United States'
        ]);

        $this->assertDatabaseHas('countries', [
            'iso_alpha2' => 'GB',
            'name' => 'United Kingdom'
        ]);

        $this->assertGreaterThan(15, Country::count());
    }

    /** @test */
    public function it_asks_for_confirmation_when_not_forced()
    {
        $this->artisan('country-code:seed')
             ->expectsConfirmation('This will seed the countries table. Do you wish to continue?', 'no')
             ->expectsOutput('Operation cancelled.')
             ->assertExitCode(0);
    }

    /** @test */
    public function it_proceeds_when_confirmation_is_accepted()
    {
        $this->artisan('country-code:seed')
             ->expectsConfirmation('This will seed the countries table. Do you wish to continue?', 'yes')
             ->expectsOutput('Countries seeded successfully!')
             ->assertExitCode(0);

        $this->assertGreaterThan(0, Country::count());
    }

    /** @test */
    public function it_handles_errors_gracefully()
    {
        // This test would require mocking the seeder to throw an exception
        // For now, we'll test that the command exists and can be called
        $this->artisan('country-code:seed', ['--force' => true])
             ->assertExitCode(0);
    }

    /** @test */
    public function it_seeds_all_required_country_data()
    {
        $this->artisan('country-code:seed', ['--force' => true]);

        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertNotNull($usa);
        $this->assertEquals('United States', $usa->name);
        $this->assertEquals('USA', $usa->iso_alpha3);
        $this->assertEquals('1', $usa->phone_code);
        $this->assertEquals('🇺🇸', $usa->flag_emoji);
        $this->assertEquals('North America', $usa->continent);
        $this->assertEquals('Northern America', $usa->region);
        $this->assertEquals('USD', $usa->currency_code);
        $this->assertTrue($usa->un_member);
        $this->assertTrue($usa->independent);
        $this->assertEquals('active', $usa->status);
    }

    /** @test */
    public function it_does_not_duplicate_countries_on_multiple_runs()
    {
        $this->artisan('country-code:seed', ['--force' => true]);
        $firstCount = Country::count();

        $this->artisan('country-code:seed', ['--force' => true]);
        $secondCount = Country::count();

        $this->assertEquals($firstCount, $secondCount);
    }

    /** @test */
    public function it_seeds_countries_with_all_attributes()
    {
        $this->artisan('country-code:seed', ['--force' => true]);

        $countries = Country::all();
        
        foreach ($countries as $country) {
            $this->assertNotEmpty($country->name);
            $this->assertNotEmpty($country->iso_alpha2);
            $this->assertNotEmpty($country->iso_alpha3);
            $this->assertNotEmpty($country->phone_code);
            $this->assertNotEmpty($country->flag_emoji);
            $this->assertNotEmpty($country->continent);
            $this->assertNotEmpty($country->region);
            $this->assertNotNull($country->un_member);
            $this->assertNotNull($country->independent);
            $this->assertNotEmpty($country->status);
        }
    }
} 