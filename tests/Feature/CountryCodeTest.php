<?php

namespace Laravel\CountryCode\Tests\Feature;

use Laravel\CountryCode\Tests\TestCase;
use Laravel\CountryCode\Models\Country;
use Laravel\CountryCode\Facades\CountryCode;
use Laravel\CountryCode\Database\Seeders\CountrySeeder;

class CountryCodeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Run the seeder
        $seeder = new CountrySeeder();
        $seeder->run();
    }

    /** @test */
    public function it_can_get_all_countries()
    {
        $countries = CountryCode::all();
        
        $this->assertNotEmpty($countries);
        $this->assertGreaterThan(15, $countries->count()); // We have 15+ countries in our seeder
    }

    /** @test */
    public function it_can_find_country_by_iso_code()
    {
        $usa = CountryCode::findByIso('US');
        
        $this->assertNotNull($usa);
        $this->assertEquals('United States', $usa->name);
        $this->assertEquals('USA', $usa->iso_alpha3);
        $this->assertEquals('1', $usa->phone_code);
    }

    /** @test */
    public function it_can_find_countries_by_phone_code()
    {
        $countries = CountryCode::findByPhoneCode('1');
        
        $this->assertNotEmpty($countries);
        $this->assertTrue($countries->contains('iso_alpha2', 'US'));
        $this->assertTrue($countries->contains('iso_alpha2', 'CA'));
    }

    /** @test */
    public function it_can_get_countries_by_continent()
    {
        $europeanCountries = CountryCode::getByContinent('Europe');
        
        $this->assertNotEmpty($europeanCountries);
        $this->assertTrue($europeanCountries->every(fn($country) => $country->continent === 'Europe'));
    }

    /** @test */
    public function it_can_search_countries()
    {
        $results = CountryCode::search('United');
        
        $this->assertNotEmpty($results);
        $this->assertTrue($results->contains('name', 'United States'));
        $this->assertTrue($results->contains('name', 'United Kingdom'));
    }

    /** @test */
    public function it_can_validate_country_codes()
    {
        $this->assertTrue(CountryCode::validate('US'));
        $this->assertTrue(CountryCode::validate('USA'));
        $this->assertFalse(CountryCode::validate('XX'));
        $this->assertFalse(CountryCode::validate('XXXX'));
    }

    /** @test */
    public function it_can_get_continents()
    {
        $continents = CountryCode::getContinents();
        
        $this->assertNotEmpty($continents);
        $this->assertContains('Europe', $continents);
        $this->assertContains('Asia', $continents);
        $this->assertContains('North America', $continents);
    }

    /** @test */
    public function it_can_get_regions()
    {
        $regions = CountryCode::getRegions();
        
        $this->assertNotEmpty($regions);
    }

    /** @test */
    public function it_can_get_phone_code_statistics()
    {
        $stats = CountryCode::getPhoneCodeStats();
        
        $this->assertIsArray($stats);
        $this->assertArrayHasKey('total_phone_codes', $stats);
        $this->assertArrayHasKey('most_shared_code', $stats);
    }

    /** @test */
    public function it_can_get_default_country()
    {
        $default = CountryCode::getDefaultCountry();
        
        $this->assertNotNull($default);
        $this->assertEquals('US', $default->iso_alpha2);
    }

    /** @test */
    public function it_can_get_un_member_countries()
    {
        $unMembers = CountryCode::getUnMembers();
        
        $this->assertNotEmpty($unMembers);
        $this->assertTrue($unMembers->every(fn($country) => $country->un_member === true));
    }

    /** @test */
    public function it_can_get_independent_countries()
    {
        $independent = CountryCode::getIndependent();
        
        $this->assertNotEmpty($independent);
        $this->assertTrue($independent->every(fn($country) => $country->independent === true));
    }

    /** @test */
    public function it_can_paginate_countries()
    {
        $paginated = CountryCode::paginate(10);
        
        $this->assertEquals(10, $paginated->perPage());
        $this->assertGreaterThan(0, $paginated->lastPage());
    }

    /** @test */
    public function it_can_get_countries_by_status()
    {
        $activeCountries = CountryCode::getByStatus('active');
        
        $this->assertNotEmpty($activeCountries);
        $this->assertTrue($activeCountries->every(fn($country) => $country->status === 'active'));
    }

    /** @test */
    public function country_model_has_required_attributes()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertNotNull($usa);
        $this->assertNotEmpty($usa->name);
        $this->assertNotEmpty($usa->iso_alpha2);
        $this->assertNotEmpty($usa->iso_alpha3);
        $this->assertNotEmpty($usa->phone_code);
        $this->assertNotEmpty($usa->flag_emoji);
        $this->assertNotEmpty($usa->continent);
        $this->assertNotEmpty($usa->region);
    }

    /** @test */
    public function country_model_has_formatted_phone_code()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertEquals('+1', $usa->formatted_phone_code);
    }

    /** @test */
    public function country_model_can_check_regional_membership()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        $germany = Country::where('iso_alpha2', 'DE')->first();
        
        $this->assertTrue($usa->isInContinent('North America'));
        $this->assertTrue($germany->isInContinent('Europe'));
        $this->assertFalse($usa->isInContinent('Europe'));
    }

    /** @test */
    public function it_can_clear_cache()
    {
        // This should not throw an exception
        CountryCode::clearCache();
        
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_get_countries_by_regional_group()
    {
        $euCountries = CountryCode::getByRegionalGroup('EU');
        
        $this->assertNotEmpty($euCountries);
        $this->assertTrue($euCountries->contains('iso_alpha2', 'DE'));
        $this->assertTrue($euCountries->contains('iso_alpha2', 'FR'));
    }
} 