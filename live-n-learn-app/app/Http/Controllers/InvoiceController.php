<?php

namespace App\Http\Controllers;

use App\Models\UserPaymentMethod;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Trip;

use App\Services\Stripe;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    private $deposit_payment = 250;
    private $fee_percentage = 0.03;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();

        $data = [
            'invoices' => $invoices
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to create invoices'
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validateInvoice();
        $attributes['uuid'] = (string) Str::uuid();
        $attributes['created_by_id'] = $auth_user->id;

        $invoice = Invoice::create($attributes);

        foreach ($attributes['invoice_items'] as &$invoice_item)
        {
            $invoice->invoice_items()->create($invoice_item);
        }

        $invoice->refresh();

        $data = [
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show_by_trip_user(User $user, Trip $trip)
    {
        $invoice = Invoice::where('recipient_id', $user->id)
                        ->where('trip_id', $trip->id)->first();

        $data = [
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $attributes = $this->validateInvoice($invoice);

        $invoice->update($attributes);

        $invoice->refresh();

        $data = [
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to delete from invoices'
            ];
            return response()->json($error, 422);
        }

        $invoice->update(['deleted_by_id' => $auth_user->id]);
        $invoice->delete();

        $data = [
            'message' => 'Invoice destroyed successfully.'
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function make_payment(Request $request, Invoice $invoice)
    {
        $stripe = new Stripe();
        $today = Carbon::today();

        $attributes = $this->validatePayment();

        $user_agent = $request->header('User-Agent');
        $ip_address = $request->ip();
        $amount = $request->amount;
        
        $fees = ($request->type == 'credit') ? $amount * $this->fee_percentage : 0;

        $total_amount = $amount + $fees;
        $amount_in_cents = $total_amount * 100; // Convert to cents

        $new_payment_token = $request->new_payment_token;
        $existing_payment_method = $request->existing_payment_method;
        $stripe_customer_id = $request->stripe_customer_id;

        if($new_payment_token && $existing_payment_method)
        {
            $error = [
                'success' => 0,
                'message' => "Please provide either 'new_payment_token' OR 'existing_payment_method'. Not both."
            ];
            return response()->json($error, 422);
        }

        $payment_method = $new_payment_token ? $new_payment_token : $existing_payment_method;

        $payment_intent = $stripe->makePayment($stripe_customer_id, $payment_method, $amount_in_cents, $ip_address, $user_agent);

        $invoice->invoice_payments()->create([
            'payment_method' => $attributes['type'],
            'stripe_payment_intent_id' => $payment_intent['id'],
            'date' => $today,
            'amount' => $amount,
            'fees' => $fees,
        ]);

        $invoice->refresh();

        $data = [
            'success' => 1,
            'message' => 'Payment Made successfully.',
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function get_user_invoices(User $user)
    {
        $invoices = Invoice::where('recipient_id', $user->id)->latest()->get();

        $data = [
            'invoices' => $invoices
        ];

        return response()->json($data);
    }

    /**
     * SET PAYMENT PLANS
     */
    public function set_payment_plan(Request $request, User $user, Trip $trip)
    {
        $invoice = Invoice::where('recipient_id', $user->id)
                        ->where('trip_id', $trip->id)->first();

        $payment_plan_attributes = $this->validatePaymentPlan();

        if($payment_plan_attributes['payment_plan_type'] == 'automated' && 
            $payment_plan_attributes['payment_method_type'] == 'check')
            {
                $data = [
                    'success' => 0,
                    'message' => 'Invalid combination for payment plan.',
                    'invoice' => $invoice
                ];

                return response()->json($data, 422);
            }

        $invoice->update($payment_plan_attributes);

        $data = [
            'success' => 1,
            'message' => 'Payment Plan added successfully.',
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function make_deposit(Request $request, Invoice $invoice)
    {
        $stripe = new Stripe();
        $today = Carbon::today();
        $auth_user = Auth::user();

        $attributes = $this->validatePayment();

        $user_agent = $request->header('User-Agent');
        $ip_address = $request->ip();
        $amount = $request->amount;

        // Check that the amount if valid
        $minimum_payment = $invoice->deposit_amount;

        if($amount < $minimum_payment)
        {
            $error = [
                'success' => 0,
                'message' => "The payment amount must be greater than or equal to $minimum_payment"
            ];
            return response()->json($error, 422);
        }

        $fees = ($request->type == 'credit') ? $amount * $this->fee_percentage : 0;

        $total_amount = $amount + $fees;
        $amount_in_cents = $total_amount * 100; // Convert to cents

        $new_payment_token = $request->new_payment_token;
        $existing_payment_method = $request->existing_payment_method;
        $stripe_customer_id = $request->stripe_customer_id;

        if(!$invoice->payment_plan_type)
        {
            $error = [
                'success' => 0,
                'message' => "You must select a payment plan."
            ];
            return response()->json($error, 422);
        }

        if($invoice->payment_plan_type == 'automated' && !$existing_payment_method)
        {
            $error = [
                'success' => 0,
                'message' => "Automated Payments are required to have a payment method on file."
            ];
            return response()->json($error, 422);
        }

        if($new_payment_token && $existing_payment_method)
        {
            $error = [
                'success' => 0,
                'message' => "Please provide either 'new_payment_token' OR 'existing_payment_method'. Not both."
            ];
            return response()->json($error, 422);
        }

        if($existing_payment_method)
        {
            $userPaymentMethod = UserPaymentMethod::where('user_id', $auth_user->id)
                                    ->where('stripe_payment_method_id', $existing_payment_method)
                                    ->first();
            
            $auth_user->update(['default_payment_method_id' => $userPaymentMethod->id]);
            $invoice->update(['default_payment_method_id' => $userPaymentMethod->id]);
        }

        $payment_method = $new_payment_token ? $new_payment_token : $existing_payment_method;

        $payment_intent = $stripe->makePayment($stripe_customer_id, $payment_method, $amount_in_cents, $ip_address, $user_agent);

        $invoice->invoice_payments()->create([
            'payment_method' => $attributes['type'],
            'stripe_payment_intent_id' => $payment_intent['id'],
            'date' => $today,
            'amount' => $amount,
            'fees' => $fees,
            'notes' => "Trip Deposit Payment"
        ]);

        $invoice->refresh();

        if($invoice->amount_due > 0)
        {
            $this->generate_payment_plan($invoice, $payment_method);
        }

        $data = [
            'success' => 1,
            'message' => 'Payment Made successfully.',
            'invoice' => $invoice
        ];

        return response()->json($data);
    }

    function generate_payment_plan(Invoice $invoice, string $payment_method)
    {
        $payment_plan_function = 'generate_'. $invoice->payment_plan_type . '_plan';
        return $this->$payment_plan_function($invoice);
    }

    function generate_automated_plan(Invoice $invoice)
    {
        $today = Carbon::today();

        $trip = Trip::find($invoice->trip_id);
        $departure_date = Carbon::parse($trip->start_date);
        $final_payment_date = $departure_date->subDays(45);
        $number_of_months = $today->diffInMonths($final_payment_date);

        $remaining_balance = $invoice->amount_due;
        $monthly_payment = round($remaining_balance / $number_of_months, 2);
        $adjustment_on_final_payment = round($remaining_balance - ($monthly_payment * $number_of_months), 2);

        for($i = 1; $i <= $number_of_months ; $i++) {
            $payment_date = $today->copy()->addMonths($i);
            $payment_amount = $monthly_payment;

            if($i == $number_of_months) $payment_amount += $adjustment_on_final_payment;

            $payment = [
                'scheduled_payment_date' => $payment_date->toDateString(),
                'amount' => round($payment_amount, 2)
            ];

            $invoice->payment_plan()->create($payment);
        }

        $invoice->refresh();

        return $invoice->payment_plan;
    }

    function generate_dual_payment_plan(Invoice $invoice)
    {
        $today = Carbon::today();

        $trip = Trip::find($invoice->trip_id);
        $departure_date = Carbon::parse($trip->start_date);

        $remaining_balance = $invoice->amount_due;

        // Just in case an odd number is halved
        $first_payment = round($remaining_balance / 2, 2);
        $second_payment = $remaining_balance - $first_payment;

        $first_payment_due_date = $today->addDays(90);
        $second_payment_due_date = $departure_date->subDays(110);

        $invoice->payment_plan()->createMany([
            [
                'scheduled_payment_date' => $first_payment_due_date->toDateString(),
                'amount' => $first_payment
            ],
            [
                'scheduled_payment_date' => $second_payment_due_date->toDateString(),
                'amount' => $second_payment
            ],
        ]);

        $invoice->refresh();

        return $invoice->payment_plan;
    }

    function validateInvoice(?Invoice $invoice = null): array
    {
        $invoice ??= new Invoice();

        return $attributes = request()->validate([
            'recipient_id' => 'required|exists:users,id',
            'trip_id' => 'nullable|exists:trips,id',
            'due_date' => 'required|date',
            'comments' => 'nullable',
            'invoice_items' => 'required|array',
            'invoice_items.*.name' => 'required', // check each item in the array
            'invoice_items.*.description' => 'nullable', // check each item in the array
            'invoice_items.*.line_total' => 'required|decimal:0,2', // check each item in the array
            'invoice_items.*.primary' => 'nullable|boolean', // check each item in the array
        ]);
    }

    function validatePayment(): array
    {
        return $attributes = request()->validate([
            'type' => ['required', Rule::in(['credit', 'ach'])],
            'new_payment_token' => 'required_without:existing_payment_method',
            'existing_payment_method' => 'required_without:new_payment_token',
            'amount' => 'required|decimal:0,2'
        ]);
    }

    function validatePaymentPlan(): array
    {
        return $attributes = request()->validate([
            'payment_plan_type' => ['required', Rule::in(['automated', 'dual_payment'])],
            'payment_method_type' => ['required', Rule::in(['stripe', 'check'])],
        ]);
    }
}
