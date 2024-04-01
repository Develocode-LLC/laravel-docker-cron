<?php

namespace App\Http\Controllers;

use App\Models\TripUserCancellationInsurance;
use App\Models\InvoiceItem;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Trip;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TripUserCancellationInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, Trip $trip)
    {
        $selectedInsuranceOption = TripUserCancellationInsurance::where('user_id', $user->id)->where('trip_id', $trip->id)->first();

        if($selectedInsuranceOption)
        {
            $data = [
                'success' => 1,
                'cancellation_insurance_selected' => 1,
                'cancellation_insurance' => $selectedInsuranceOption
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'success' => 1,
                'cancellation_insurance_selected' => 0
            ];
    
            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user, Trip $trip)
    {
        $invoice = Invoice::where('recipient_id', $user->id)
                        ->where('trip_id', $trip->id)->first();

        if($invoice->payments)
        {
            $error = [
                'success' => 0,
                'message' => "A cancellation insurance option cannot be chosen at this time."
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validateCancellationInsurance();
        $attributes['user_id'] = $user->id;
        $attributes['trip_id'] = $trip->id;

        if($attributes['type'] != 'none'){
            $cancellationInsuranceFunction = $attributes['type'] . '_cost';
            $attributes['amount'] = $trip->$cancellationInsuranceFunction;
        }

        $selectedInsuranceOption = TripUserCancellationInsurance::where('user_id', $user->id)->where('trip_id', $trip->id)->delete();
        $invoice_items = InvoiceItem::where('name', 'like', '%Cancellation Insurance')->delete();

        $cancellationInsurance = TripUserCancellationInsurance::create($attributes);

        if($attributes['type'] != 'none')
        {
            $invoice->invoice_items()->create([
                'name' => ucwords($attributes['type']) . ' Cancellation Insurance',
                'line_total' => $cancellationInsurance->amount,
                'primary' => 0
            ]);
        }

        $invoice->refresh();

        $data = [
            'success' => 1,
            'message' => "A cancellation insurance option has been selected.",
            'invoice' => $invoice,
            'cancellation_insurance_option' => $cancellationInsurance
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, User $user, Trip $trip, TripUserCancellationInsurance $selectedInsuranceOption)
    {
        $invoice = Invoice::where('recipient_id', $user->id)
                        ->where('trip_id', $trip->id)->first();
        
        if($invoice->payments)
        {
            $error = [
                'success' => 0,
                'message' => "A cancellation insurance option cannot be chosen at this time."
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validateCancellationInsurance();
        $attributes['user_id'] = $user->id;
        $attributes['trip_id'] = $trip->id;

        if($attributes['type'] != 'none'){
            $cancellationInsuranceFunction = $attributes['type'] . '_cost';
            $attributes['amount'] = $trip->$cancellationInsuranceFunction;
        }

        $cancellationInsurance = TripUserCancellationInsurance::create($attributes);

        $invoice->invoice_items()->update([
            'name' => ucwords($attributes['type']) . ' Cancellation Insurance',
            'line_total' => $cancellationInsurance->amount,
            'primary' => 0
        ]);

        $invoice->refresh();

        $data = [
            'success' => 1,
            'message' => "A cancellation insurance option has been selected.",
            'invoice' => $invoice,
            'cancellation_insurance_option' => $cancellationInsurance
        ];

        return response()->json($data);
    }

    function validateCancellationInsurance(): array
    {
        return $attributes = request()->validate([
            'type' => ['required', Rule::in(['none', 'basic', 'elite'])],
        ]);
    }
}
