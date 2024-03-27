<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AvailabilityDates;

class AvailabilityDatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth_user = Auth::user();

        $availability_dates = AvailabilityDates::where('user_id', $auth_user->id)
        ->latest()->get();

        $data = [
            'availability_dates' => $availability_dates
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth_user = Auth::user();
        $attributes = $this->validateAvailabilityDates();
        
        # Check for overlapping dates
        $overlapping_dates = AvailabilityDates::where('user_id', $auth_user->id)
                                ->where('end_date', '>', $attributes['start_date'])
                                ->where('start_date', '<', $attributes['end_date'])
                                ->count();

        if($overlapping_dates > 0)
        {
            $error = [
                'message' => 'This date overlaps an existing set of dates'
            ];
            return response()->json($error, 422);
        }

        $attributes['user_id'] = $auth_user->id;

        $availability_date = AvailabilityDates::create($attributes);

        $data = [
            'availability_date' => $availability_date
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(AvailabilityDates $availability_date)
    {
        $auth_user = Auth::user();

        if($availability_date->user_id <> $auth_user->id)
        {
            $error = [
                'message' => 'Invalid Request'
            ];
            return response()->json($error, 422);
        }

        $data = [
            'availability_date' => $availability_date
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvailabilityDates $availability_date)
    {
        $auth_user = Auth::user();

        if($availability_date->user_id <> $auth_user->id)
        {
            $error = [
                'message' => 'Invalid Request'
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validateAvailabilityDates($availability_date);
        
        # Check for overlapping dates
        # Not including the current availability date
        $overlapping_dates = AvailabilityDates::where('user_id', $auth_user->id)
                                ->whereNot('id', $availability_date->id)
                                ->where('end_date', '>', $attributes['start_date'])
                                ->where('start_date', '<', $attributes['end_date'])
                                ->count();

        if($overlapping_dates > 0)
        {
            $error = [
                'message' => 'This date overlaps an existing set of dates'
            ];
            return response()->json($error, 422);
        }
                        
        $availability_date->update($attributes);

        $data = [
            'availability_date' => $availability_date
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvailabilityDates $availability_date)
    {
        $auth_user = Auth::user();

        if($availability_date->user_id <> $auth_user->id)
        {
            $error = [
                'message' => 'Invalid Request'
            ];
            return response()->json($error, 422);
        }

        $availability_date->delete();

        $data = [
            'message' => 'Availability Date Deleted'
        ];

        return response()->json($data);
    }

    function validateAvailabilityDates(?AvailabilityDates $availability_date = null): array
    {
        $availability_date ??= new AvailabilityDates();

        return $attributes = request()->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    }
}
