<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Campaign;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that campaigns index page loads successfully.
     */
    public function test_campaigns_index_page_loads()
    {
        // Create a sample campaign
        $campaign = Campaign::factory()->create([
            'program_category' => 'pendidikan',
            'status' => 'published'
        ]);

        $response = $this->get(route('campaigns.index', 'pendidikan'));

        $response->assertStatus(200);
        $response->assertSee($campaign->title);
    }

    /**
     * Test that campaign detail page loads successfully.
     */
    public function test_campaign_detail_page_loads()
    {
        // Create a sample campaign
        $campaign = Campaign::factory()->create([
            'program_category' => 'kesehatan',
            'status' => 'published'
        ]);

        $response = $this->get(route('campaigns.show', ['kesehatan', $campaign]));

        $response->assertStatus(200);
        $response->assertSee($campaign->title);
    }

    /**
     * Test that campaign progress percentage is calculated correctly.
     */
    public function test_campaign_progress_percentage_calculation()
    {
        $campaign = new Campaign([
            'target_amount' => 1000000,
            'collected_amount' => 250000
        ]);

        $this->assertEquals(25, $campaign->progress_percentage);
    }

    /**
     * Test that campaign with zero target amount returns 0 progress.
     */
    public function test_campaign_with_zero_target_returns_zero_progress()
    {
        $campaign = new Campaign([
            'target_amount' => 0,
            'collected_amount' => 100000
        ]);

        $this->assertEquals(0, $campaign->progress_percentage);
    }
}
