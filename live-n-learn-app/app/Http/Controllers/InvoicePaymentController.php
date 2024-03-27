<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class InvoicePaymentController extends Controller
{
    private $payment_method_array = [
        'ach',
        'cash',
        'check',
        'credit',
        'other'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Invoice $invoice)
    {
        $invoicePayments = InvoicePayment::where('invoice_id', $invoice->id)->orderBy('date', 'DESC')->get();
        
        $data = [
            'invoice_payments' => $invoicePayments
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Invoice $invoice)
    {
        $attributes = $this->validateInvoicePayment();

        $invoice_payment = $invoice->invoice_payments()->create($attributes);

        $data = [
            'invoice_payment' => $invoice_payment
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice, InvoicePayment $invoicePayment)
    {
        // Check that invoice and invoice payment match
        if($invoice->id === $invoicePayment->invoice_id)
        {
            $data = [
                'invoice_payment' => $invoicePayment
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Invoice Payment'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice, InvoicePayment $invoicePayment)
    {
        // Check that invoice and invoice payment match
        if($invoice->id === $invoicePayment->invoice_id)
        {
            $attributes = $this->validateInvoicePayment($invoicePayment);

            $invoicePayment->update($attributes);

            $data = [
                'invoice_payment' => $invoicePayment
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Invoice Payment'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, InvoicePayment $invoicePayment)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to delete from invoice payments'
            ];
            return response()->json($error, 422);
        }

        // Check that invoice and invoice payment match
        if($invoice->id === $invoicePayment->invoice_id)
        {
            $invoicePayment->delete();

            $data = [
                'message' => 'Invoice Payment destroyed successfully.'
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Invoice Payment'
            ];
    
            return response()->json($data, 422);
        }
    }

    function validateInvoicePayment(?InvoicePayment $invoice_payment = null): array
    {
        $invoice_payment ??= new InvoicePayment();

        return $attributes = request()->validate([
            'user_payment_method_id' => 'nullable|exists:user_payment_methods,id',
            'payment_method' => ['required', Rule::in($this->payment_method_array)],
            'date' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'notes' => 'nullable',
        ]);
    }
}
