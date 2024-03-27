<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Invoice $invoice)
    {
        $data = [
            'invoice_items' => $invoice->invoice_items
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Invoice $invoice)
    {
        $attributes = $this->validateInvoiceItem();

        $invoice_item = $invoice->invoice_items()->create($attributes);

        $data = [
            'invoice_item' => $invoice_item
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        // Check that invoice and invoice item match
        if($invoice->id === $invoiceItem->invoice_id)
        {
            $data = [
                'invoice_item' => $invoiceItem
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Invoice Item'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice, InvoiceItem $invoiceItem)
    {
        // Check that invoice and invoice item match
        if($invoice->id === $invoiceItem->invoice_id)
        {
            $attributes = $this->validateInvoiceItem($invoiceItem);

            $invoiceItem->update($attributes);

            $data = [
                'invoice_item' => $invoiceItem
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Invoice Item'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to delete from invoice items'
            ];
            return response()->json($error, 422);
        }

        // Check that invoice and invoice item match
        if($invoice->id === $invoiceItem->invoice_id)
        {
            $invoiceItem->delete();

            $data = [
                'message' => 'Invoice Item destroyed successfully.'
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Invoice Item'
            ];
    
            return response()->json($data, 422);
        }
    }

    function validateInvoiceItem(?InvoiceItem $invoice_item = null): array
    {
        $invoice_item ??= new InvoiceItem();

        return $attributes = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'line_total' => 'required|decimal:0,2'
        ]);
    }
}
