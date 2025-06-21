<?php

namespace Laravelgpt\CountryCode\Tests\Unit;

use Laravelgpt\CountryCode\Tests\TestCase;
use Laravelgpt\CountryCode\Models\Country;
use Laravelgpt\CountryCode\Database\Seeders\CountrySeeder;

class CountryModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $seeder = new CountrySeeder();
        $seeder->run();
    }

    /** @test */
    public function it_has_correct_table_name()
    {
        $country = new Country();
        $this->assertEquals('countries', $country->getTable());
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $country = new Country();
        $fillable = $country->getFillable();
        
        $this->assertContains('name', $fillable);
        $this->assertContains('iso_alpha2', $fillable);
        $this->assertContains('iso_alpha3', $fillable);
        $this->assertContains('phone_code', $fillable);
        $this->assertContains('flag_emoji', $fillable);
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $country = new Country();
        $casts = $country->getCasts();
        
        $this->assertEquals('array', $casts['languages']);
        $this->assertEquals('integer', $casts['population']);
        $this->assertEquals('float', $casts['area_km2']);
        $this->assertEquals('boolean', $casts['un_member']);
    }

    /** @test */
    public function it_returns_formatted_phone_code()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertEquals('+1', $usa->formatted_phone_code);
    }

    /** @test */
    public function it_returns_flag_html_entity()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertNotEmpty($usa->flag_html);
        $this->assertStringStartsWith('&#x', $usa->flag_html);
    }

    /** @test */
    public function it_checks_continental_membership()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        $germany = Country::where('iso_alpha2', 'DE')->first();
        
        $this->assertTrue($usa->isInContinent('North America'));
        $this->assertTrue($germany->isInContinent('Europe'));
        $this->assertFalse($usa->isInContinent('Europe'));
    }

    /** @test */
    public function it_checks_regional_membership()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        $germany = Country::where('iso_alpha2', 'DE')->first();
        
        $this->assertTrue($usa->isInRegion('Northern America'));
        $this->assertTrue($germany->isInRegion('Western Europe'));
    }

    /** @test */
    public function it_returns_phone_format()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertNotEmpty($usa->getPhoneFormat());
    }

    /** @test */
    public function it_returns_phone_example()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        $this->assertNotEmpty($usa->getPhoneExample());
        $this->assertStringContainsString('+1', $usa->getPhoneExample());
    }

    /** @test */
    public function it_scopes_by_continent()
    {
        $europeanCountries = Country::inContinent('Europe')->get();
        
        $this->assertNotEmpty($europeanCountries);
        $this->assertTrue($europeanCountries->every(fn($country) => $country->continent === 'Europe'));
    }

    /** @test */
    public function it_scopes_by_region()
    {
        $westernEurope = Country::inRegion('Western Europe')->get();
        
        $this->assertNotEmpty($westernEurope);
        $this->assertTrue($westernEurope->every(fn($country) => $country->region === 'Western Europe'));
    }

    /** @test */
    public function it_scopes_un_members()
    {
        $unMembers = Country::unMembers()->get();
        
        $this->assertNotEmpty($unMembers);
        $this->assertTrue($unMembers->every(fn($country) => $country->un_member === true));
    }

    /** @test */
    public function it_scopes_independent()
    {
        $independent = Country::independent()->get();
        
        $this->assertNotEmpty($independent);
        $this->assertTrue($independent->every(fn($country) => $country->independent === true));
    }

    /** @test */
    public function it_scopes_by_search()
    {
        $unitedCountries = Country::search('United')->get();
        
        $this->assertNotEmpty($unitedCountries);
        $this->assertTrue($unitedCountries->contains('name', 'United States'));
        $this->assertTrue($unitedCountries->contains('name', 'United Kingdom'));
    }

    /** @test */
    public function it_scopes_by_phone_code()
    {
        $phoneCode1 = Country::byPhoneCode('1')->get();
        
        $this->assertNotEmpty($phoneCode1);
        $this->assertTrue($phoneCode1->every(fn($country) => $country->phone_code === '1'));
    }

    /** @test */
    public function it_scopes_by_iso()
    {
        $usByIso = Country::byIso('US')->get();
        
        $this->assertNotEmpty($usByIso);
        $this->assertTrue($usByIso->contains('iso_alpha2', 'US'));
    }

    /** @test */
    public function it_has_neighbors_relationship()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        // This should not throw an exception
        $neighbors = $usa->neighbors();
        $this->assertNotNull($neighbors);
    }

    /** @test */
    public function it_has_regional_partners_relationship()
    {
        $usa = Country::where('iso_alpha2', 'US')->first();
        
        // This should not throw an exception
        $partners = $usa->regionalPartners();
        $this->assertNotNull($partners);
    }
} 