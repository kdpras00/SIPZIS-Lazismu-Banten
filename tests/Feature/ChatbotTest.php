<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    /**
     * Test chatbot endpoint.
     */
    public function test_chatbot_endpoint_exists(): void
    {
        $response = $this->postJson('/chatbot', [
            'message' => 'Hello, what is this system for?'
        ]);

        // We're just checking if the endpoint exists and returns a JSON response
        // The actual content will depend on the Gemini API
        $response->assertStatus(200)
            ->assertJsonStructure(['success']);
    }

    /**
     * Test chatbot with empty message.
     */
    public function test_chatbot_with_empty_message(): void
    {
        $response = $this->postJson('/chatbot', [
            'message' => ''
        ]);

        $response->assertStatus(422); // Validation error
    }
}
