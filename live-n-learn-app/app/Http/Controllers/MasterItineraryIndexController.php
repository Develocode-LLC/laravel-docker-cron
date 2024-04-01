<?php

namespace App\Http\Controllers;

use App\Models\MasterItineraryIndex;
use App\Models\MasterItinerary;
use Illuminate\Http\Request;

class MasterItineraryIndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MasterItinerary $masterItinerary)
    {
        $data = [
            'itinerary_overview' => $masterItinerary->overview
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, MasterItinerary $masterItinerary)
    {
        $trip_itineraries;
        $attributes_array = $this->validateItineraryOverview();
        
        $ids = array_column($attributes_array['overview'], 'id');

        $itineraries_to_delete = MasterItineraryIndex::where('master_itinerary_id', $masterItinerary->id)->get();

        $masterItinerary->overview()->whereNotIn('id', $ids)->delete();

        foreach($attributes_array['overview'] as &$attributes)
        {
            if(isset($attributes['id']))
            {
                $trip_itinerary = $masterItinerary->overview()->find($attributes['id']);
                $trip_itinerary->update($attributes);
            }
            else
            {
                $trip_itinerary = $masterItinerary->overview()->create($attributes);
            }
        }

        $masterItinerary->refresh();

        $data = [
            'itinerary_overview' => $masterItinerary->overview
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterItinerary $masterItinerary, MasterItineraryIndex $masterItineraryIndex)
    {
        // Check that master itinerary and master itinerary index match
        if($masterItinerary->id === $masterItineraryIndex->master_itinerary_id)
        {
            $data = [
                'itinerary_overview_item' => $masterItineraryIndex
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Itinerary Item'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterItinerary $masterItinerary, MasterItineraryIndex $masterItineraryIndex)
    {
        // Check that master itinerary and master itinerary index match
        if($masterItinerary->id === $masterItineraryIndex->master_itinerary_id)
        {
            $attributes = $this->validateItinerary($masterItineraryIndex);

            if($attributes['itinerary_index'] !== $masterItineraryIndex->itinerary_index)
            {
                // Reorganize itinerary
                $this->reorganize_itinerary($masterItinerary, $masterItineraryIndex->itinerary_index, $attributes['itinerary_index']);
            }

            $masterItineraryIndex->update($attributes);
            
            $data = [
                'itinerary_overview_item' => $masterItineraryIndex
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
    public function destroy(MasterItineraryIndex $masterItineraryIndex)
    {
        // Check that master itinerary and master itinerary index match
        if($masterItinerary->id === $masterItineraryIndex->master_itinerary_id)
        {
            $masterItineraryIndex->delete();

            $data = [
                'message' => 'Itinerary Item destroyed successfully.'
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Itinerary Item'
            ];
    
            return response()->json($data, 422);
        }
    }

    function validateItinerary(?MasterItineraryIndex $masterItineraryIndex = null): array
    {
        $masterItineraryIndex ??= new MasterItineraryIndex();

        return $attributes = request()->validate([
            'itinerary_index' => 'required',
            'itinerary_date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
            'title' => 'required',
            'content' => 'required',
            'media_file_id' => 'nullable|exists:media_files,id',
        ]);
    }

    function validateItineraryOverview(): array
    {
        return $attributes = request()->validate([
            'overview' => 'required|array',
            'overview.*.id' => 'nullable',
            'overview.*.itinerary_index' => 'required',
            'overview.*.itinerary_date' => 'nullable|date',
            'overview.*.time' => 'nullable|date_format:H:i:s',
            'overview.*.title' => 'required',
            'overview.*.content' => 'required',
            'overview.*.media_file_id' => 'nullable|exists:media_files,id',
        ]);
    }

    function reorganize_itinerary(MasterItinerary $masterItinerary, int $ignore_itinerary_index, int $new_itinerary_index)
    {
        $beginning_itinerary =  $masterItinerary->overview()
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

        $ending_itinerary =     $masterItinerary->overview()
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
