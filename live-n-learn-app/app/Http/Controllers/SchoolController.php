<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\School;
use App\Models\Trip;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::orderBy('name')->get();

        $data = [
            'schools' => $schools
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validateSchool();
        $school = School::create($attributes);

        $data = [
            'school' => $school
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        $data = [
            'school' => $school
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $attributes = $this->validateSchool($school);
        $school->update($attributes);

        $data = [
            'school' => $school
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        $school->delete();

        $data = [
            'message' => 'School destroyed successfully.'
        ];

        return response()->json($data);
    }

    /**
     * Assign a School to the trip
     */
    public function assign_trip(School $school, Trip $trip)
    {
        $school->trips()->attach($trip->id);

        $data = [
            'message' => 'Trip has been assigned successfully'
        ];

        return response()->json($data);
    }

    function validateSchool(?School $school = null): array
    {
        $school ??= new School();

        return $attributes = request()->validate([
            'code' => 'required|max:10|unique:schools,code,' . $school->id,
            'name' => 'required',
            'address_1' => 'required',
            'address_2' => 'nullable',
            'city' => 'required',
            'state_province' => 'required',
            'postal_code' => 'required',
            'country_code' => 'required'
        ]);
    }
}
