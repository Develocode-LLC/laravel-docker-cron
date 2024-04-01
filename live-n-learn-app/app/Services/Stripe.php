<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

use App\Models\User;

class Stripe
{
    private $stripe;
    private $apiKey;

    private $classes = ['parent', 'traveler'];

    /**
     * Initialize the class
     */
    public function __construct()
    {
        $this->apiKey = config('services.stripe.apikey');
        $this->stripe = new StripeClient($this->apiKey);

        return;
    }

    public function createCustomer(User $user)
    {
        # We only want to create a stripe customer for travelers and parents
        if(!in_array($user->class, $this->classes)) return;

        $stripe_customer = $this->stripe->customers->create([
            'name' => $user->full_name,
            'email' => $user->email,
            'address' => [
                'line1' => $user->address_1,
                'line2' => $user->address_2,
                'city' => $user->city,
                'state' => $user->state_province,
                'postal_code' => $user->postal_code,
                'country' => $user->country_code,
            ],
            'phone' => $user->phone_number,
        ]);

        json_decode($stripe_customer);

        $user->update([
            'stripe_customer_id' => $stripe_customer['id']
        ]);

        return;
    }

    public function updateCustomer(User $user)
    {
        # Only update customers if they have an id
        if(!$user->stripe_customer_id) return;

        $stripe_customer = $this->stripe->customers->update(
            $user->stripe_customer_id,
            [
                'name' => $user->full_name,
                'email' => $user->email,
                'address' => [
                    'line1' => $user->address_1,
                    'line2' => $user->address_2,
                    'city' => $user->city,
                    'state' => $user->state_province,
                    'postal_code' => $user->postal_code,
                    'country' => $user->country_code,
                ],
                'phone' => $user->phone_number,
            ]
        );
        json_decode($stripe_customer);

        return;
    }

    public function createPaymentMethod(User $user, string $sourceToken)
    {
        $requires_verification = 0;

        # Only update customers if they have an id
        if(!$user->stripe_customer_id) return;

        $stripe_customer_source = $this->stripe->customers->createSource($user->stripe_customer_id, ['source' => $sourceToken]);

        json_decode($stripe_customer_source);

        if($stripe_customer_source['object'] == 'bank_account')
        {
            if($stripe_customer_source['status'] != 'verified')
            {
                $requires_verification = 1;
            }
        }

        // Create payment_method in db
        $payment_method = $user->payment_methods()->create([
            'stripe_payment_method_id' => $stripe_customer_source['id'],
            'requires_verification' => $requires_verification
        ]);

        return $payment_method;
    }

    public function getPaymentMethod(User $user, string $stripe_payment_method_id)
    {
        if(!$user->stripe_customer_id) return;

        $stripe_payment_method_obj = $this->stripe->customers->retrievePaymentMethod(
            $user->stripe_customer_id,
            $stripe_payment_method_id,
            []
        );

        json_decode($stripe_payment_method_obj);

        return $stripe_payment_method_obj;
    }

    function getBankAccount(User $user, string $stripe_payment_method_id)
    {
        $url = "https://api.stripe.com/v1/customers/$user->stripe_customer_id/bank_accounts/$stripe_payment_method_id";

        //  Initiate curl
        $ch = curl_init();

        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->apiKey
        ));

        // Execute
        $result = curl_exec($ch);

        // Closing
        curl_close($ch);

        // Decode JSON
        $result = preg_replace("/[\r\n]+/", "", $result);
        $data = json_decode(str_replace('\"', '"', $result));

        return $data;
    }

    public function verifyBankAccount(User $user, string $stripe_payment_method_id, array $verification_amounts)
    {
        if(!$user->stripe_customer_id) return;

        $stripe_payment_method_obj = $this->stripe->customers->verifySource(
            $user->stripe_customer_id,
            $stripe_payment_method_id,
            ['amounts' => $verification_amounts]
        );

        return $stripe_payment_method_obj;
    }

    public function deletePaymentMethod(User $user, string $stripe_payment_method_id)
    {
        # Only update customers if they have an id
        if(!$user->stripe_customer_id) return;

        $stripe_payment_method_obj = $this->stripe->customers->deleteSource(
            $user->stripe_customer_id,
            $stripe_payment_method_id,
            []
        );

        json_decode($stripe_payment_method_obj);

        return $stripe_payment_method_obj['deleted'];
    }

    public function getPaymentIntent(string $stripe_payment_intent_id)
    {
        $stripe_payment_intent_obj = $this->stripe->paymentIntents->retrieve(
            $stripe_payment_intent_id, 
            []
        );

        json_decode($stripe_payment_intent_obj);

        return $stripe_payment_intent_obj;
    }

    public function makePayment(string $stripe_customer_id, string $payment_method_id, int $amount, ?string $ip_address = null, ?string $user_agent = null)
    {
        # Only make a payment with payment method and amount
        if(!$stripe_customer_id || !$payment_method_id || !$amount) return;

        $mandate_data = [];

        if($ip_address && $user_agent)
        {
            $mandate_data = [
                'customer_acceptance' => [
                    'type' => 'online',
                    'online' => [
                        'ip_address' => $ip_address,
                        'user_agent' => $user_agent
                    ]
                ]
            ];
        }
        else
        {
            $mandate_data = [
                'customer_acceptance' => [
                    'type' => 'offline'
                ]
            ];
        }

        $stripe_payment_intent_obj = $this->stripe->paymentIntents->create([
            'customer' => $stripe_customer_id,
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method' => $payment_method_id,
            'payment_method_types' => ['card', 'us_bank_account'],
            'mandate_data' => $mandate_data,
            'confirm' => true
        ]);

        json_decode($stripe_payment_intent_obj);

        return $stripe_payment_intent_obj;
    }


}
