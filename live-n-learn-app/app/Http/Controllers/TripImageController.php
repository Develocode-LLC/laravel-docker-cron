<?php

namespace App\Http\Controllers;

use App\Models\TripImage;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Trip $trip)
    {
        $data = [
            'itinerary_images' => $trip->images
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Trip $trip)
    {
        $file_path;
        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()) {
                $file_path = Storage::put("trip/{$trip->id}/images", $image);
            }
        }
        
        $tripImage = $trip->images()->create([
            'file_location' => $file_path
        ]);

        $data = [
            'trip_image' => $tripImage
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip, TripImage $tripImage)
    {
        // Check that the trip image belong to the trip
        if($trip->id === $tripImage->trip_id)
        {
            $data = [
                'trip_image' => $tripImage
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Image'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip, TripImage $tripImage)
    {
        // Check that the trip image belong to the trip
        if($trip->id === $tripImage->trip_id)
        {
            $tripImage->delete();

            $data = [
                'message' => 'Trip Image destroyed successfully.'
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Image'
            ];
    
            return response()->json($data, 422);
        }
    }
}
