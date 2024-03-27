<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

use App\Models\User;

class Stripe
{
    private $stripe;

    private $classes = ['parent', 'traveler'];

    /**
     * Initialize the class
     */
    public function __construct()
    {
        $api_key = config('services.stripe.apikey');
        $this->stripe = new StripeClient($api_key);

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
        # Only update customers if they have an id
        if(!$user->stripe_customer_id) return;

        $stripe_customer_source = $this->stripe->customers->createSource($user->stripe_customer_id, ['source' => $sourceToken]);

        json_decode($stripe_customer_source);

        // Create payment_method in db
        $payment_method = $user->payment_methods()->create([
            'stripe_payment_method_id' => $stripe_customer_source['id'],
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

    public function makePayment(string $stripe_customer_id, string $payment_method_id, int $amount)
    {
        # Only make a payment with payment method and amount
        if(!$stripe_customer_id || !$payment_method_id || !$amount) return;

        /*
            $payment = [
                'amount' => 2000,       // in cents, so this equals $20.00
                'currency' => 'usd',
                'payment_method' => $payment_method_id,
            ];
        */

        $stripe_payment_intent_obj = $this->stripe->paymentIntents->create([
            'customer' => $stripe_customer_id,
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method' => $payment_method_id,
            'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
            'confirm' => true
        ]);

        json_decode($stripe_payment_intent_obj);

        return $stripe_payment_intent_obj;
    }


}
