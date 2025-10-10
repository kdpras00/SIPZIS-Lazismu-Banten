<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\ZakatPayment;
use App\Models\Muzakki;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ZakatPaymentRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admin_or_staff_can_be_set_as_received_by()
    {
        // Create users with different roles
        $adminUser = User::factory()->create(['role' => 'admin']);
        $staffUser = User::factory()->create(['role' => 'staff']);
        $muzakkiUser = User::factory()->create(['role' => 'muzakki']);

        // Create a muzakki
        $muzakki = Muzakki::factory()->create();

        // Test that admin can be set as received_by
        $payment1 = ZakatPayment::create([
            'payment_code' => 'ZKT-2024-001',
            'muzakki_id' => $muzakki->id,
            'zakat_amount' => 100000,
            'paid_amount' => 100000,
            'payment_method' => 'cash',
            'payment_date' => now(),
            'status' => 'completed',
            'receipt_number' => 'RCP-202401-0001',
            'received_by' => $adminUser->id,
        ]);

        $this->assertEquals($adminUser->id, $payment1->received_by);

        // Test that staff can be set as received_by
        $payment2 = ZakatPayment::create([
            'payment_code' => 'ZKT-2024-002',
            'muzakki_id' => $muzakki->id,
            'zakat_amount' => 150000,
            'paid_amount' => 150000,
            'payment_method' => 'cash',
            'payment_date' => now(),
            'status' => 'completed',
            'receipt_number' => 'RCP-202401-0002',
            'received_by' => $staffUser->id,
        ]);

        $this->assertEquals($staffUser->id, $payment2->received_by);

        // Test that muzakki cannot be set as received_by (should be nullified by observer)
        $payment3 = ZakatPayment::create([
            'payment_code' => 'ZKT-2024-003',
            'muzakki_id' => $muzakki->id,
            'zakat_amount' => 200000,
            'paid_amount' => 200000,
            'payment_method' => 'cash',
            'payment_date' => now(),
            'status' => 'completed',
            'receipt_number' => 'RCP-202401-0003',
            'received_by' => $muzakkiUser->id,
        ]);

        $this->assertNull($payment3->received_by);
    }
}
