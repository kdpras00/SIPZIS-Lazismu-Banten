<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPayment;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        Log::info('Midtrans Notification', (array) $notif);

        $payment = ZakatPayment::where('payment_code', $order_id)->first();

        if ($payment) {
            if ($transaction == 'capture') {
                if ($type == 'credit_card' && $fraud == 'challenge') {
                    $payment->status = 'challenge';
                } else {
                    $payment->status = 'success';
                }
            } else if ($transaction == 'settlement') {
                $payment->status = 'success';
            } else if ($transaction == 'pending') {
                $payment->status = 'pending';
            } else if ($transaction == 'deny') {
                $payment->status = 'failed';
            } else if ($transaction == 'expire') {
                $payment->status = 'expired';
            } else if ($transaction == 'cancel') {
                $payment->status = 'cancelled';
            }
            $payment->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
