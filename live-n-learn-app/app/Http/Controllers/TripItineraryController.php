<?php

namespace App\Http\Controllers;

use App\Models\TripItinerary;
use App\Models\Trip;
use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;

class TripItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Trip $trip)
    {
        $data = [
            'itinerary' => $trip->itinerary
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Trip $trip)
    {
        $attributes = $this->validateTripItinerary();
        $existing_itinerary = $trip->itinerary()->where('itinerary_index', '>=', $attributes["itinerary_index"] )->orderBy('itinerary_index')->get();
        $trip_itinerary = $trip->itinerary()->create($attributes);

        foreach ($existing_itinerary as &$itinerary)
        {
            $current_tinerary_index = $itinerary['itinerary_index'];
            $itinerary->update([
                'itinerary_index' => $current_tinerary_index + 1
            ]);
        }

        $data = [
            'trip_itinerary' => $trip_itinerary
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip, TripItinerary $trip_itinerary)
    {
        // Check that trip and trip itinerary match
        if($trip->id === $trip_itinerary->trip_id)
        {
            $data = [
                'trip_itinerary' => $trip_itinerary
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Itinerary'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip, TripItinerary $trip_itinerary)
    {
        // Check that trip and trip itinerary match
        if($trip->id === $trip_itinerary->trip_id)
        {
            $attributes = $this->validateTripItinerary($trip_itinerary);

            if($attributes['itinerary_index'] !== $trip_itinerary->itinerary_index)
            {
                // Reorganize itinerary
                $this->reorganize_itinerary($trip, $trip_itinerary->itinerary_index, $attributes['itinerary_index']);
            }

            $trip_itinerary->update($attributes);
            
            $data = [
                'trip_itinerary' => $trip_itinerary
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Itinerary'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip, TripItinerary $trip_itinerary)
    {
        // Check that trip and trip itinerary match
        if($trip->id === $trip_itinerary->trip_id)
        {
            $trip_itinerary->delete();

            $data = [
                'message' => 'Trip Itinerary destroyed successfully.'
            ];

            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Itinerary'
            ];
    
            return response()->json($data, 422);
        }
    }

    function validateTripItinerary(?TripItinerary $trip_itinerary = null): array
    {
        $trip_itinerary ??= new TripItinerary();

        return $attributes = request()->validate([
            'itinerary_index' => 'required',
            'itinerary_date' => 'required|date',
            'title' => 'required',
            'content' => 'required',
            'media_file_id' => 'nullable|exists:media_files,id',
        ]);
    }

    function reorganize_itinerary(Trip $trip, int $ignore_itinerary_index, int $new_itinerary_index)
    {
        $beginning_itinerary =  $trip->itinerary()
                                    ->where('itinerary_index', '<=', $new_itinerary_index)
                                    ->where('itinerary_index', '<>', $ignore_itinerary_index)
                                    ->orderBy('itinerary_index')
                                    ->get();
        
        $starting_index = 1;
        foreach ($beginning_itinerary as &$itinerary)
        {
            $itinerary->update([
                'itinerary_index' => $starting_index
            ]);

            $starting_index++;
        }

        $ending_itinerary =     $trip->itinerary()
                                    ->where('itinerary_index', '>=', $new_itinerary_index)
                                    ->where('itinerary_index', '<>', $ignore_itinerary_index)
                                    ->orderBy('itinerary_index')
                                    ->get();

        $starting_index = $new_itinerary_index + 1;
        foreach ($ending_itinerary as &$itinerary)
        {
            $itinerary->update([
                'itinerary_index' => $starting_index
            ]);

            $starting_index++;
        }
    }
}
