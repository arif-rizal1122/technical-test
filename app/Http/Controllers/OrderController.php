<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * (a) Checkout API: Membuat pesanan dan item pesanan.
     */
    public function checkout(Request $request)
    {
        // Pastikan pengguna sudah login (dijamin oleh auth:sanctum)
        $user = $request->user();

        try {
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.product_id' => 'required|integer|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'shipping_address' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        }
        
        $items = $validated['items'];
        $totalPrice = 0;
        $orderItemsData = [];
        $productUpdates = [];
        
        DB::beginTransaction();

        try {
            $productIds = collect($items)->pluck('product_id')->unique()->toArray();
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                $quantity = $item['quantity'];

                if (!$product || $product->stock < $quantity) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error', 
                        'message' => "Stock not enough for product ID {$item['product_id']} ({$product->name}). Remaining stock: {$product->stock}"
                    ], 400);
                }

                $subtotal = $product->price * $quantity;
                $totalPrice += $subtotal;
                
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price_at_order' => $product->price,
                    'subtotal' => $subtotal,
                ];

                $productUpdates[] = [
                    'id' => $product->id,
                    'decrement' => $quantity
                ];
            }
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . time() . '-' . $user->id, 
                'total_amount' => $totalPrice,
                'shipping_address' => $validated['shipping_address'],
                'status' => 'pending', // Status awal
            ]);
            
            $order->items()->createMany($orderItemsData);
      
            foreach ($productUpdates as $update) {
                 DB::table('products')
                   ->where('id', $update['id'])
                   ->decrement('stock', $update['decrement']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Checkout successful. Order created and waiting for payment.',
                'order' => $order->only('order_number', 'total_price', 'status')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process checkout. ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * (b) Riwayat Pemesanan API: Mendapatkan semua pesanan pengguna beserta detail itemnya.
     */
    public function history(Request $request)
    {
        $user = $request->user();

      
        $orders = $user->orders()
                       ->with('items.product')
                       ->latest() 
                       ->paginate(10);
                       
        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No order history found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order history retrieved successfully.',
            'data' => $orders
        ], 200);
    }


        
    public function processPayment(Request $request, string $order_number)
    {
        $user = $request->user();

        try {
            $validated = $request->validate([
                'payment_method' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment method is required.'
            ], 422);
        }

        $paymentMethod = strtoupper($validated['payment_method']);
        $allowedMethods = ['BCA', 'BNI', 'MANDIRI', 'PERMATA'];

        if (!in_array($paymentMethod, $allowedMethods)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid payment method.'
            ], 422);
        }

        $order = Order::where('order_number', $order_number)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found or access denied.'
            ], 404);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => "Order status is {$order->status}. Payment cannot be initiated."
            ], 400);
        }

        $externalId = 'ORDER-' . $order->order_number . '-' . time();
        $apiKey = env('XENDIT_SECRET_KEY');

        try {
            $response = Http::withBasicAuth($apiKey, '')
                ->post('https://api.xendit.co/callback_virtual_accounts', [
                    'external_id' => $externalId,
                    'bank_code' => $paymentMethod,
                    'name' => $user->name,
                    'expected_amount' => (int) $order->total_amount,
                    'is_closed' => true,
                    'callback_url' => env('XENDIT_WEBHOOK_URL'), 
                    'callback_token' => env('XENDIT_WEBHOOK_SECRET')
                ]);

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create virtual account with Payment Gateway.',
                    'details' => $response->json(),
                ], $response->status());
            }

            $pgData = $response->json();

            if (!isset($pgData['account_number'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment gateway did not return a valid response.',
                    'details' => $pgData,
                ], 500);
            }

            $payment = Payment::create([
                'order_id' => $order->id,
                'pg_transaction_id' => $pgData['id'] ?? null,
                'amount' => $order->total_amount,
                'method' => $pgData['bank_code'] ?? $paymentMethod,
                'status' => 'pending',
                'pg_response_data' => $pgData,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Virtual Account created successfully.',
                'payment_details' => [
                    'order_number' => $order->order_number,
                    'bank' => $pgData['bank_code'],
                    'virtual_account_number' => $pgData['account_number'],
                    'amount' => $order->total_amount,
                    'expiry_date' => $pgData['expiration_date'] ?? null,
                    'payment_id' => $payment->id,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error during payment initiation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}