<?php

namespace App\Observers;

use App\Models\ZakatPayment;
use App\Models\Campaign;
use App\Models\Program;
use App\Models\User;

class ZakatPaymentObserver
{
    /**
     * Handle the ZakatPayment "creating" event.
     */
    public function creating(ZakatPayment $zakatPayment): void
    {
        // Validate that received_by can only be set by admin or staff
        $this->validateReceivedBy($zakatPayment);
    }

    /**
     * Handle the ZakatPayment "updating" event.
     */
    public function updating(ZakatPayment $zakatPayment): void
    {
        // Validate that received_by can only be set by admin or staff
        $this->validateReceivedBy($zakatPayment);
    }

    /**
     * Handle the ZakatPayment "created" event.
     */
    public function created(ZakatPayment $zakatPayment): void
    {
        // Update campaign collected amount when a new payment is created
        if ($zakatPayment->status === 'completed' && $zakatPayment->program_category) {
            $this->updateCampaignAndProgramTotals($zakatPayment);
        }
    }

    /**
     * Handle the ZakatPayment "updated" event.
     */
    public function updated(ZakatPayment $zakatPayment): void
    {
        // Update campaign collected amount when payment status changes to completed
        if ($zakatPayment->isDirty('status') && $zakatPayment->status === 'completed' && $zakatPayment->program_category) {
            $this->updateCampaignAndProgramTotals($zakatPayment);
        }
    }

    /**
     * Handle the ZakatPayment "deleted" event.
     */
    public function deleted(ZakatPayment $zakatPayment): void
    {
        // Update campaign collected amount when a payment is deleted
        if ($zakatPayment->status === 'completed' && $zakatPayment->program_category) {
            $this->updateCampaignAndProgramTotals($zakatPayment);
        }
    }

    /**
     * Handle the ZakatPayment "restored" event.
     */
    public function restored(ZakatPayment $zakatPayment): void
    {
        // Update campaign collected amount when a payment is restored
        if ($zakatPayment->status === 'completed' && $zakatPayment->program_category) {
            $this->updateCampaignAndProgramTotals($zakatPayment);
        }
    }

    /**
     * Handle the ZakatPayment "force deleted" event.
     */
    public function forceDeleted(ZakatPayment $zakatPayment): void
    {
        // Update campaign collected amount when a payment is force deleted
        if ($zakatPayment->status === 'completed' && $zakatPayment->program_category) {
            $this->updateCampaignAndProgramTotals($zakatPayment);
        }
    }

    /**
     * Validate that received_by can only be set by admin or staff users
     */
    private function validateReceivedBy(ZakatPayment $zakatPayment): void
    {
        // If received_by is being set, check that it references an admin or staff user
        if ($zakatPayment->received_by !== null) {
            $user = User::find($zakatPayment->received_by);
            if ($user && $user->role !== 'admin' && $user->role !== 'staff') {
                // Reset to null if not admin or staff
                $zakatPayment->received_by = null;
            }
        }
    }

    /**
     * Update campaign and program totals based on payment
     */
    private function updateCampaignAndProgramTotals(ZakatPayment $zakatPayment): void
    {
        // Find campaigns with the same program category
        $campaigns = Campaign::where('program_category', $zakatPayment->program_category)->get();

        // Update each campaign's collected amount
        foreach ($campaigns as $campaign) {
            // The collected amount is calculated dynamically in the model accessor
            // So we don't need to update the database field directly
            // But we can trigger any necessary recalculations here if needed
        }

        // Find program with the same category
        $program = Program::where('category', $zakatPayment->program_category)->first();

        if ($program) {
            // The program totals are calculated dynamically in the model accessor
            // So we don't need to update the database field directly
            // But we can trigger any necessary recalculations here if needed
        }
    }
}
