<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    /**
     * Test postal code validation endpoint
     */
    public function test_validate_postal_code_endpoint()
    {
        $response = $this->postJson('/regions/validate-postal-code', [
            'district' => 'Jatiuwung'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test postal code validation with empty district
     */
    public function test_validate_postal_code_with_empty_district()
    {
        $response = $this->postJson('/regions/validate-postal-code', [
            'district' => ''
        ]);

        $response->assertStatus(422); // Validation error
    }

    /**
     * Test get postal code by village endpoint
     */
    public function test_get_postal_code_by_village()
    {
        $response = $this->postJson('/regions/get-postal-code', [
            'village' => 'Cipondoh'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test countries endpoint
     */
    public function test_countries_endpoint()
    {
        $response = $this->get('/regions/countries');

        $response->assertStatus(200);
    }

    /**
     * Test provinces endpoint
     */
    public function test_provinces_endpoint()
    {
        $response = $this->get('/regions/provinces/indonesia');

        $response->assertStatus(200);
    }
}
