<?php

namespace App\Http\Controllers;

use App\Models\MasterItinerary;
use Illuminate\Http\Request;


class MasterItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masterItineraries = MasterItinerary::orderBy('title')->get();

        $data = [
            'itineraries' => $masterItineraries
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validateMasterItinerary();
        $masterItinerary = MasterItinerary::create($attributes);

        $destinations = $request->destinations;
        $masterItinerary->destinations()->sync($destinations);

        $data = [
            'itinerary' => $masterItinerary
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterItinerary $masterItinerary)
    {
        $data = [
            'itinerary' => $masterItinerary
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterItinerary $masterItinerary)
    {
        $attributes = $this->validateMasterItinerary($masterItinerary);
        $masterItinerary->update($attributes);

        $destinations = $request->destinations;
        $masterItinerary->destinations()->sync($destinations);

        $masterItinerary->refresh();

        $data = [
            'itinerary' => $masterItinerary
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource in storage.
     */
    public function destroy(MasterItinerary $masterItinerary)
    {
        $masterItinerary->update([
            'code' => null
        ]);

        $masterItinerary->delete();

        $data = [
            'message' => 'Master Itinerary destroyed successfully.'
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function duplicate(Request $request, MasterItinerary $masterItinerary)
    {
        $cloned_itinerary = $masterItinerary->replicate([
            'code'
        ]);
        $cloned_itinerary->push();

        // Clone related items
        foreach ($masterItinerary->overview as $overview_item) {
            $cloned_overview_item = $overview_item->replicate();
            $cloned_itinerary->overview()->save($cloned_overview_item);
        }

        foreach ($masterItinerary->images as $image) {
            $cloned_image = $image->replicate();
            $cloned_itinerary->images()->save($cloned_image);
        }

        $cloned_itinerary->refresh();

        $data = [
            'duplicate_itinerary' => $cloned_itinerary
        ];

        return response()->json($data);
    }

    /**
     * Update the destinations of the trip
     */
    public function update_destinations(Request $request, MasterItinerary $masterItinerary)
    {
        $destinations = $request->destinations;

        $masterItinerary->destinations()->sync($destinations);

        $data = [
            'message' => 'Destinations updated'
        ];

        return response()->json($data);
    }

    /**
     * Look Up a MasterItinerary by the assigned code
     */
    public function code_lookup(MasterItinerary $masterItinerary)
    {
        $data = [
            'itinerary' => $masterItinerary
        ];

        return response()->json($data);
    }

    function validateMasterItinerary(?MasterItinerary $masterItinerary = null): array
    {
        $masterItinerary ??= new MasterItinerary();

        return $attributes = request()->validate([
            'code' => 'unique:master_itineraries,code,' . $masterItinerary->id,
            'destination_location_id' => 'nullable|exists:locations,id',
            'title' => 'required',
            'description' => 'nullable',
            'destinations' => 'required|array',
            'destinations.*' => 'exists:locations,id', // check each item in the array
        ]);
    }
}
