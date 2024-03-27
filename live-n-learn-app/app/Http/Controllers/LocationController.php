<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::latest()->get();

        $data = [
            'locations' => $locations
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validateLocation();
        $location = Location::create($attributes);

        $data = [
            'location' => $location
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = Location::findOrFail($id);

        $data = [
            'location' => $location
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = Location::findOrFail($id);

        $attributes = $this->validateLocation($location);
        $location->update($attributes);

        $data = [
            'location' => $location
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);

        $location->destroy();

        $data = [
            'message' => 'Location destroyed successfully.'
        ];

        return response()->json($data);
    }

    function validateLocation(?Location $location = null): array
    {
        $location ??= new Location();

        return $attributes = request()->validate([
            'name' => 'required',
            'city' => 'required',
            'state_province' => 'required',
            'country' => 'required',
        ]);
    }
}
