<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

// Imported Models
use App\Models\Trip;
use App\Models\User;
use App\Models\School;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MasterItinerary;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::latest()->get();

        $data = [
            'trips' => $trips
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validateTrip();
        $trip = Trip::create($attributes);

        $destinations = $request->destinations;
        $trip->destinations()->sync($destinations);

        $data = [
            'trip' => $trip
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        $data = [
            'trip' => $trip
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $current_price = $trip->total_cost;

        $attributes = $this->validateTrip($trip);
        $trip->update($attributes);

        $new_price = $trip->total_cost;

        if($current_price !== $new_price) $this->updateInvoices($trip);

        $destinations = $request->destinations;
        $trip->destinations()->sync($destinations);

        $trip->refresh();

        $data = [
            'trip' => $trip
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to delete from trips'
            ];
            return response()->json($error, 422);
        }

        $trip->update([
            'code' => null,
            'deleted_by_id' => $auth_user->id
        ]);

        $trip->delete();

        $data = [
            'message' => 'Trip destroyed successfully.'
        ];

        return response()->json($data);
    }

    /**
     * Add User to trip
     */
    public function add_user(Trip $trip, User $user)
    {
        $hasUser = $trip->users()->where('user_id', $user->id)->exists();

        if ($hasUser)
        {
            return response()->json(['message' => 'User already exists in trip'], 422);
        }

        $trip->users()->attach($user);

        $data = [
            'message' => 'User added to trip',
            'user' => $user,
        ];

        return response()->json($data);
    }

    /**
     * Remove User from trip
     */
    public function remove_user(Trip $trip, User $user)
    {
        $hasUser = $trip->users()->where('user_id', $user->id)->exists();

        if (!$hasUser)
        {
            return response()->json(['message' => 'User does not exists in trip'], 422);
        }

        $trip->users()->detach($user);

        $data = [
            'message' => 'User removed from trip',
            'user' => $user,
        ];

        return response()->json($data);
    }

    /**
     * Update the destinations of the trip
     */
    public function update_destinations(Request $request, Trip $trip)
    {
        $destinations = $request->destinations;

        $trip->destinations()->sync($destinations);

        $data = [
            'message' => 'Destinations updated'
        ];

        return response()->json($data);
    }

    /**
     * Copy an existing itinerary to the trip
     */
    public function assign_itinerary(Request $request, Trip $trip, MasterItinerary $masterItinerary)
    {
        // Clone related tasks
        foreach ($masterItinerary->overview as $overview_item) {
            $trip->itinerary()->create($overview_item->toArray());
        }

        foreach ($masterItinerary->images as $image) {
            $trip->images()->create($image->toArray());
        }

        foreach ($masterItinerary->destinations as $destination) {
            $trip->destinations()->create($destination->toArray());
        }

        $trip->refresh();

        $data = [
            'trip' => $trip
        ];

        return response()->json($data);
    }

    /**
     * Look Up a Trip by the assigned code
     */
    public function code_lookup(Request $request, Trip $trip)
    {
        $data = [
            'trip' => $trip
        ];

        return response()->json($data);
    }

    /**
     * Create random string
     */
    public function _random_characters(int $length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Generate the trip code
     */
    public function generate_code(Trip $trip)
    {
        $trip_code = '';
        $trips_count = 0;

        if($trip->code)
        {
            return response()->json(['message' => "Trip is already active"], 422);
        }

        do {
            $trip_code = $this->_random_characters(5);

            $trip_count = Trip::where('code', '=', $trip_code)->count();

        } while($trips_count > 0 );

        $trip->update([
            'code' => $trip_code
        ]);

        $data = [
            'trip' => $trip
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function duplicate(Request $request, Trip $trip)
    {
        $cloned_trip = $trip->replicate([
            'code'
        ]);
        $cloned_trip->push();

        // Clone related items
        foreach ($trip->itinerary as $itinerary) {
            $cloned_itinerary = $itinerary->replicate();
            $cloned_trip->overview()->save($cloned_itinerary);
        }

        foreach ($trip->images as $image) {
            $cloned_image = $image->replicate();
            $cloned_trip->images()->save($cloned_image);
        }

        $cloned_trip->refresh();

        $data = [
            'duplicate_trip' => $cloned_trip
        ];

        return response()->json($data);
    }

    private function updateInvoices(Trip $trip)
    {
        $invoices = Invoice::select('id')->where('trip_id', $trip->id);
        $invoice_items_updated = InvoiceItem::whereIn('invoice_id', $invoices)
                                    ->where('name', 'Trip Cost')
                                    ->update(['line_total' => $trip->total_cost]);
        return;
    }

    function validateTrip(?Trip $trip = null): array
    {
        $trip ??= new Trip();

        return $attributes = request()->validate([
            'type' => ['required', Rule::in(['travel', 'homestay'])],
            'code' => 'required|unique:trips,code,' . $trip->id,
            'school_id' => 'nullable|exists:schools,id',
            'partner_id' => 'nullable|exists:partners,id',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'registration_cutoff_date' => 'required|date',
            'min_available_seats' => 'nullable|integer',
            'max_available_seats' => 'required|integer',
            'total_cost' => 'nullable|decimal:0,2',
            'basic_cost' => 'nullable|decimal:0,2',
            'elite_cost' => 'nullable|decimal:0,2',
            'origination_location_id' => 'required|exists:locations,id',
            'destinations' => 'required|array',
            'destinations.*' => 'exists:locations,id', // check each item in the array
        ]);
    }
}
