<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    const PRO_AMOUNT = 49900; // ₹499.00, in paise

    public function createOrder()
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $order = $api->order->create([
            'amount' => self::PRO_AMOUNT,
            'currency' => 'INR',
            'receipt' => 'user_' . Auth::id() . '_' . time(),
        ]);

        Payment::create([
            'user_id' => Auth::id(),
            'razorpay_order_id' => $order['id'],
            'amount' => self::PRO_AMOUNT,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => self::PRO_AMOUNT,
            'currency' => 'INR',
            'key' => config('services.razorpay.key'),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        if ($payment->status === 'paid') {
            return response()->json(['message' => 'Payment already verified.']);
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            // A valid signature only proves Razorpay issued these IDs together — it
            // doesn't confirm the payment was actually captured (vs. authorized-but-
            // not-captured, which can later expire without taking money), or that the
            // amount/order match what we created. Re-fetch server-to-server and check
            // both before granting the entitlement.
            $razorpayPayment = $api->payment->fetch($request->razorpay_payment_id);

            if ($razorpayPayment['status'] !== 'captured'
                || $razorpayPayment['order_id'] !== $payment->razorpay_order_id
                || (int) $razorpayPayment['amount'] !== $payment->amount) {
                throw new \Exception('Payment not captured, or amount/order mismatch.');
            }
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);

            return response()->json(['error' => 'Payment verification failed.'], 422);
        }

        $payment->update([
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
            'status' => 'paid',
        ]);

        return response()->json(['message' => 'Payment verified. Welcome to Pro!']);
    }

    /**
     * Server-to-server confirmation from Razorpay — the only path that isn't
     * dependent on the customer's browser staying open after payment.
     */
    public function webhook(Request $request)
    {
        $signature = $request->header('X-Razorpay-Signature');
        $secret = config('services.razorpay.webhook_secret');

        if (!$signature || !$secret) {
            return response()->json(['error' => 'Webhook not configured.'], 400);
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $api->utility->verifyWebhookSignature($request->getContent(), $signature, $secret);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid webhook signature.'], 400);
        }

        if ($request->input('event') === 'payment.captured') {
            $entity = $request->input('payload.payment.entity', []);

            if (!empty($entity['order_id'])) {
                Payment::where('razorpay_order_id', $entity['order_id'])
                    ->where('status', '!=', 'paid')
                    ->update([
                        'razorpay_payment_id' => $entity['id'] ?? null,
                        'status' => 'paid',
                    ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
