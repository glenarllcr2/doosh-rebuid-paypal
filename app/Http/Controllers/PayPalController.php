<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected $provider;
    protected $payPalToken;

    public function __construct()
    {
        $this->provider = new PayPalClient();
        $this->provider->setApiCredentials(config('paypal'));
        $this->payPalToken = $this->provider->getAccessToken();
    }

    public function createPayment(Request $request)
    {
        $planId = $request->input('plan_id');
        $plan = Plan::findOrFail($planId);
        //dd($plan->name);
        $paymentData = [
            'intent' => 'CAPTURE', 
            'purchase_units' => [
                [
                    'amount' => [
                        'value' => '33.99',
                        'currency_code' => 'USD',
                    ],
                    'description' => "Payment for plan:". $plan->name,
                ],
            ],
            'application_context' => [
                'return_url' => route('payment.status'),
                'cancel_url' => route('payment.cancel'),
            ],
        ];
        


        $response = $this->provider->createOrder($paymentData);

        if(isset($response['id']) && $response['id'] != null) {
            foreach($response['links'] as $link) {
                if($link['rel'] == 'approve') {
                    session()->put('plan_name', $plan->name);
                    //session()->put()
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('payment.cancel');
        }
        //dd(env('PAYPAL_SANDBOX_CLIENT_ID'));
        //dd($paymentData, $response);
        // // هدایت به پی پال برای تایید
        // if ($response['status'] == 'CREATED') {
        //     foreach ($response['links'] as $link) {
        //         if ($link['rel'] == 'approve') {
        //             return redirect()->away($link['href']);
        //         }
        //     }
        // }

        return redirect()->route('payment.cancel');
    }

    public function paymentStatus(Request $request)
    {
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        $payment = $this->provider->getPaymentDetails($paymentId);

        if ($payment['state'] === 'approved') {
            // فعال‌سازی اشتراک برای کاربر
            $user = auth()->user();
            $user->subscriptions()->create([
                'plan_id' => session('plan_id'),
                'price_paid' => $payment['transactions'][0]['amount']['total'],
                'status' => 'active',
                'end_date' => now()->addMonth(), // یا مدت زمان دیگر بر اساس پلن
            ]);
    
            return redirect()->route('dashboard')->with('success', 'Your subscription is now active.');
        }

        return redirect()->route('dashboard')->with('error', 'Payment failed.');
    }

    public function paymentCancel()
    {
        // کاربر پرداخت را لغو کرده است
        return redirect()->route('payment.cancel');
    }

    public function paymentSuccess(Request $request)
    {
        $response = $this->provider->capturePaymentOrder($request->token);
        return view('payment.success');
    }
}
