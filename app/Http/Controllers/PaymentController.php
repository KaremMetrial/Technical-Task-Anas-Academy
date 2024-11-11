<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function showForm(Request $request)
    {

        return view('payment.form', $request->only('product_id', 'product_name', 'product_price'));
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {

            $amount = $request->product_price * 100;

            $charge = Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for ' . $request->product_name . ' (Order #' . $request->product_id . ')',
            ]);


            return redirect()->route('payment.success');
        } catch (\Exception $e) {

            return redirect()->route('payment.error')->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return view('payment.success');
    }

    public function error()
    {
        return view('payment.error');
    }

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->server(key: 'HTTP_STRIPE_SIGNATURE');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        if (!$sig_header) {
            return response()->json(['status' => 'error', 'message' => 'Signature header not found'], 400);
        }

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    break;
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }


}
