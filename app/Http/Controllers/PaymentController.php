<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handleWebhook(Request $request)
    {
        try {
            $data = $request->all();

            if (!isset($data['external_id'], $data['status'])) {
                return response()->json(['message' => 'Invalid payload'], 400);
            }

            $externalId = $data['external_id'];
            $status = strtolower($data['status']);

            $orderNumber = str_replace('ORDER-', '', $externalId);
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $payment = Payment::where('order_id', $order->id)->latest()->first();

            $orderStatus = $paymentStatus = 'pending'; 

            if (in_array($status, ['settled', 'paid'])) {
                $orderStatus = 'success';
                $paymentStatus = 'success';
            } elseif (in_array($status, ['expired', 'failed'])) {
                $orderStatus = $status;     
                $paymentStatus = $status;
            }

            $order->status = $orderStatus;
            $order->save();

            if ($payment) {
                $payment->status = $paymentStatus;
                $payment->save();
            }

            return response()->json([
                'message' => 'Webhook processed successfully.',
                'received' => $data,
                'order_status' => $orderStatus,
                'payment_status' => $paymentStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook Error: '.$e->getMessage());
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
