<?php

namespace Laravel\CountryCode\Tests\Feature;

use Laravel\CountryCode\Tests\TestCase;
use Laravel\CountryCode\Database\Seeders\CountrySeeder;

class ApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $seeder = new CountrySeeder();
        $seeder->run();
    }

    /** @test */
    public function it_can_get_all_countries_via_api()
    {
        $response = $this->get('/api/countries');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'iso_alpha2',
                    'iso_alpha3',
                    'phone_code',
                    'flag_emoji',
                    'continent',
                    'region'
                ]
            ],
            'pagination' => [
                'current_page',
                'last_page',
                'per_page',
                'total'
            ]
        ]);
    }

    /** @test */
    public function it_can_get_specific_country_via_api()
    {
        $response = $this->get('/api/countries/US');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'iso_alpha2' => 'US',
                'name' => 'United States'
            ]
        ]);
    }

    /** @test */
    public function it_returns_404_for_invalid_country_code()
    {
        $response = $this->get('/api/countries/XX');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Country not found'
        ]);
    }

    /** @test */
    public function it_can_search_countries_via_api()
    {
        $response = $this->get('/api/countries/search?q=United');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_requires_search_query()
    {
        $response = $this->get('/api/countries/search');

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Search query is required'
        ]);
    }

    /** @test */
    public function it_can_get_countries_by_phone_code()
    {
        $response = $this->get('/api/countries/phone/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'phone_code',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_countries_by_continent()
    {
        $response = $this->get('/api/countries/continent/Europe');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'continent',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_countries_by_region()
    {
        $response = $this->get('/api/countries/region/Western%20Europe');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'region',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_all_continents()
    {
        $response = $this->get('/api/countries/continents');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        $this->assertContains('Europe', $data);
        $this->assertContains('Asia', $data);
    }

    /** @test */
    public function it_can_get_all_regions()
    {
        $response = $this->get('/api/countries/regions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_countries_by_regional_group()
    {
        $response = $this->get('/api/countries/group/EU');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'group',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_phone_statistics()
    {
        $response = $this->get('/api/countries/stats/phone');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'total_phone_codes',
                'most_shared_code',
                'least_shared_code',
                'average_countries_per_code',
                'codes_with_multiple_countries'
            ]
        ]);
    }

    /** @test */
    public function it_can_validate_country_code()
    {
        $response = $this->post('/api/countries/validate', [
            'code' => 'US'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'valid' => true,
            'code' => 'US'
        ]);
    }

    /** @test */
    public function it_validates_invalid_country_code()
    {
        $response = $this->post('/api/countries/validate', [
            'code' => 'XX'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'valid' => false,
            'code' => 'XX'
        ]);
    }

    /** @test */
    public function it_requires_code_for_validation()
    {
        $response = $this->post('/api/countries/validate', []);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Country code is required'
        ]);
    }

    /** @test */
    public function it_can_get_un_member_countries()
    {
        $response = $this->get('/api/countries/un-members');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_independent_countries()
    {
        $response = $this->get('/api/countries/independent');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'total'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }

    /** @test */
    public function it_can_get_default_country()
    {
        $response = $this->get('/api/countries/default');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data'
        ]);
        
        $data = $response->json('data');
        $this->assertNotNull($data);
    }

    /** @test */
    public function it_supports_pagination()
    {
        $response = $this->get('/api/countries?per_page=5');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'pagination' => [
                'current_page',
                'last_page',
                'per_page',
                'total'
            ]
        ]);
        
        $pagination = $response->json('pagination');
        $this->assertEquals(5, $pagination['per_page']);
    }

    /** @test */
    public function it_supports_filtering_by_status()
    {
        $response = $this->get('/api/countries?status=active');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'pagination'
        ]);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }
} 