<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Trip;

use App\Services\Stripe;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
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
        $this->validatePayment();

        $today = Carbon::today();

        $amount = $request->amount;
        $amount_in_cents = $amount * 100; // Convert to cents

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

        $payment_intent = $stripe->makePayment($stripe_customer_id, $payment_method, $amount_in_cents);

        $invoice->invoice_payments()->create([
            'payment_method' => 'credit',
            'stripe_payment_intent_id' => $payment_intent['id'],
            'date' => $today,
            'amount' => $amount
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
        ]);
    }

    function validatePayment(): array
    {
        return $attributes = request()->validate([
            'new_payment_token' => 'required_without:existing_payment_method',
            'existing_payment_method' => 'required_without:new_payment_token',
            'amount' => 'required|decimal:0,2'
        ]);
    }
}
