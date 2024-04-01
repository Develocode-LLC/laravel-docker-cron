<?php

namespace App\Http\Controllers;

use App\Models\TripForm;
use Illuminate\Http\Request;

use App\Models\Trip;
use App\Models\Form;

class TripFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Trip $trip)
    {
        $data = [
            'trip_forms' => $trip->forms
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip, Form $form)
    {
        $hasForm = $trip->forms()->where('form_id', $form->id)->exists();

        if ($hasForm)
        {
            $data = [
                'success' => 0,
                'message' => 'Form already exists in trip'
            ];

            return response()->json($data, 422);
        }

        $trip->forms()->create([
            'form_id' => $form->id
        ]);

        $data = [
            'success' => 1,
            'message' => 'Form added to trip',
            'trip_form' => $form,
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip, Form $form)
    {
        $tripForms = $trip->forms->where('form_id', $form->id);

        if($tripForms)
        {
            foreach ($tripForms as $tripForm) 
            {
                $tripForm->delete();
            }
        }

        $data = [
            'success' => 1,
            'message' => 'Form removed from to trip'
        ];

        return response()->json($data);
    }
}
