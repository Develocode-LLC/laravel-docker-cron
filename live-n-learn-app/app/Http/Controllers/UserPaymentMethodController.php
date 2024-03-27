<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Stripe;

use App\Models\User;
use App\Models\UserPaymentMethod;
use Illuminate\Support\Facades\Auth;

class UserPaymentMethodController extends Controller
{
    private $classes = ['parent', 'traveler'];

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {

        $data = [ ];
        
        $auth_user = Auth::user();

        // This is a traveler
        if($auth_user->class === 'administrator' || ($auth_user->id === $user->id && in_array($auth_user->class, $this->classes)))
        {
            $data = [
                'payment_methods' => $user->payment_methods
            ];
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $sourceToken = $request->input('stripe_token');

        $stripe = new Stripe();

        if(($auth_user->id === $user->id && in_array($auth_user->class, $this->classes)))
        {
            if(!$user->stripe_customer_id) $stripe->createCustomer($user);

            $user->refresh();

            $payment_method = $stripe->createPaymentMethod($user, $sourceToken);

            $data = [
                'payment_method' => $payment_method
            ];
    
            return response()->json($data);
        }

        return response()->json(['success' => 0, 'message' => 'Unable to create payment method'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, UserPaymentMethod $userPaymentMethod)
    {
        $auth_user = Auth::user();
        $user ??= $auth_user->user();

        if($user->id != $userPaymentMethod->user_id) return response()->json(['success' => 0, 'message' => 'Invalid Payment Method'], 422);

        // This is a traveler
        if($auth_user->class === 'administrator' || ($auth_user->id === $user->id && in_array($auth_user->class, $this->classes)))
        {
            $data = [
                'payment_method' => $userPaymentMethod
            ];
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserPaymentMethod $userPaymentMethod)
    {
        $stripe = new Stripe();
        $auth_user = Auth::user();

        $user ??= $auth_user->user();

        if($user->id != $userPaymentMethod->user_id) return response()->json(['success' => 0, 'message' => 'Invalid Payment Method'], 422);

        // This is a traveler
        if($auth_user->class === 'administrator' || ($auth_user->id === $user->id && in_array($auth_user->class, $this->classes)))
        {
            $stripe_payment_method_id = $userPaymentMethod->stripe_payment_method_id;
            $stripe_payment_deleted = $stripe->deletePaymentMethod($user, $stripe_payment_method_id);

            if($stripe_payment_deleted)
            {
                $userPaymentMethod->delete();
                return response()->json(['success' => 1, 'message' => 'Payment Method Deleted']);
            }
        }

        return response()->json(['success' => 0, 'message' => 'Unable to delete payment method'], 422);
    }
}
