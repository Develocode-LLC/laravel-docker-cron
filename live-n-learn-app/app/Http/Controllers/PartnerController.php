<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::orderBy('name')->get();

        $data = [
            'partners' => $partners
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validatePartner();
        $partner = Partner::create($attributes);

        $data = [
            'partner' => $partner
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        $data = [
            'partner' => $partner
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $attributes = $this->validatePartner($partner);
        $partner->update($attributes);

        $partner->refresh();

        $data = [
            'partner' => $partner
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        $data = [
            'message' => 'Partner destroyed successfully.'
        ];

        return response()->json($data);
    }

    function validatePartner(?Partner $partner = null): array
    {
        $partner ??= new Partner();

        return $attributes = request()->validate([
            'type' => ['required', Rule::in(['Inbound', 'Outbound', 'Both'])],
            'name' => 'required',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'city' => 'nullable',
            'state_province' => 'nullable',
            'postal_code' => 'nullable',
            'country_code' => 'nullable',
            'country_phone_code' => 'nullable',
            'phone_number' => 'nullable',
        ]);
    }
}
