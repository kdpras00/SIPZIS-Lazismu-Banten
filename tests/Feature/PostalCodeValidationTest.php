<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostalCodeValidationTest extends TestCase
{
    /**
     * Test postal code validation endpoint
     */
    public function test_postal_code_validation_with_valid_district()
    {
        $response = $this->postJson('/regions/validate-postal-code', [
            'district' => 'Jatiuwung'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'postal_codes',
            'suggestion'
        ]);
    }

    /**
     * Test postal code validation with empty district
     */
    public function test_postal_code_validation_with_empty_district()
    {
        $response = $this->postJson('/regions/validate-postal-code', [
            'district' => ''
        ]);

        $response->assertStatus(422); // Validation error
    }

    /**
     * Test postal code validation with non-existent district
     */
    public function test_postal_code_validation_with_nonexistent_district()
    {
        $response = $this->postJson('/regions/validate-postal-code', [
            'district' => 'NonExistentDistrict12345'
        ]);

        // Should either return 404 or success with empty results
        $response->assertStatus(200)
            ->assertJson([
                'success' => false
            ]);
    }

    /**
     * Test village postal code retrieval
     */
    public function test_village_postal_code_retrieval()
    {
        $response = $this->postJson('/regions/get-postal-code', [
            'village' => 'Cipondoh'
        ]);

        $response->assertStatus(200);
    }
}
