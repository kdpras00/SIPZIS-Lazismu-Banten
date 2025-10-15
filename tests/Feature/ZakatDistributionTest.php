<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ZakatDistribution;
use App\Models\Mustahik;
use App\Models\ZakatPayment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ZakatDistributionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $mustahik;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Create a verified mustahik
        $this->mustahik = Mustahik::factory()->create([
            'verification_status' => 'verified',
            'is_active' => true
        ]);
    }

    /** @test */
    public function it_prevents_distribution_when_insufficient_balance()
    {
        // Ensure no payments exist to create zero balance
        $this->assertEquals(0, ZakatPayment::completed()->sum('paid_amount'));
        $this->assertEquals(0, ZakatDistribution::sum('amount'));

        $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount');
        $this->assertEquals(0, $availableBalance);

        // Try to create a distribution with amount greater than available balance
        $response = $this->actingAs($this->user)->post(route('distributions.store'), [
            'mustahik_id' => $this->mustahik->id,
            'amount' => 100000, // 100,000 which is greater than 0 balance
            'distribution_type' => 'cash',
            'distribution_date' => now()->format('Y-m-d'),
        ]);

        // Check that we get an error message
        $response->assertSessionHas('error', 'Saldo zakat tidak mencukupi');

        // Check that no distribution was created
        $this->assertEquals(0, ZakatDistribution::count());
    }

    /** @test */
    public function it_allows_distribution_when_sufficient_balance()
    {
        // Create a payment to have positive balance
        ZakatPayment::factory()->create([
            'paid_amount' => 500000, // 500,000
            'status' => 'completed'
        ]);

        $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount');
        $this->assertEquals(500000, $availableBalance);

        // Try to create a distribution with amount less than available balance
        $response = $this->actingAs($this->user)->post(route('distributions.store'), [
            'mustahik_id' => $this->mustahik->id,
            'amount' => 100000, // 100,000 which is less than 500,000 balance
            'distribution_type' => 'cash',
            'distribution_date' => now()->format('Y-m-d'),
        ]);

        // Check that distribution was created successfully
        $response->assertSessionHas('success');
        $this->assertEquals(1, ZakatDistribution::count());

        // Check the distribution details
        $distribution = ZakatDistribution::first();
        $this->assertEquals(100000, $distribution->amount);
        $this->assertEquals('cash', $distribution->distribution_type);
    }

    /** @test */
    public function it_prevents_distribution_when_exact_balance_is_exceeded()
    {
        // Create a payment to have positive balance
        ZakatPayment::factory()->create([
            'paid_amount' => 100000, // 100,000
            'status' => 'completed'
        ]);

        // Create an existing distribution
        ZakatDistribution::factory()->create([
            'amount' => 50000 // 50,000
        ]);

        $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount');
        $this->assertEquals(50000, $availableBalance);

        // Try to create a distribution that would exceed the balance
        $response = $this->actingAs($this->user)->post(route('distributions.store'), [
            'mustahik_id' => $this->mustahik->id,
            'amount' => 60000, // 60,000 which is greater than 50,000 balance
            'distribution_type' => 'cash',
            'distribution_date' => now()->format('Y-m-d'),
        ]);

        // Check that we get an error message
        $response->assertSessionHas('error', 'Saldo zakat tidak mencukupi');

        // Check that no new distribution was created (still only 1 from setup)
        $this->assertEquals(1, ZakatDistribution::count());
    }
}
