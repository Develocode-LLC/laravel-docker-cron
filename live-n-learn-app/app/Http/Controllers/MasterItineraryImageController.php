<?php

namespace App\Http\Controllers;

use App\Models\MasterItineraryImage;
use App\Models\MasterItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterItineraryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MasterItinerary $masterItinerary)
    {
        $data = [
            'itinerary_images' => $masterItinerary->images
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, MasterItinerary $masterItinerary)
    {
        $file_path;
        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()) {
                $file_path = Storage::put("itinerary/{$masterItinerary->id}/images", $image);
            }
        }
        
        $masterItineraryImage = $masterItinerary->images()->create([
            'file_location' => $file_path
        ]);

        $data = [
            'itinerary_image' => $masterItineraryImage
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterItinerary $masterItinerary, MasterItineraryImage $masterItineraryImage)
    {
        // Check that master itinerary and master itinerary image match
        if($masterItinerary->id === $masterItineraryImage->master_itinerary_id)
        {
            $data = [
                'itinerary_image' => $masterItineraryImage
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Itinerary Image'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterItinerary $masterItinerary, MasterItineraryImage $masterItineraryImage)
    {
        // Check that master itinerary and master itinerary image match
        if($masterItinerary->id === $masterItineraryImage->master_itinerary_id)
        {
            $masterItineraryImage->delete();

            $data = [
                'message' => 'Itinerary Image destroyed successfully.'
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Itinerary Image'
            ];
    
            return response()->json($data, 422);
        }
    }
}
