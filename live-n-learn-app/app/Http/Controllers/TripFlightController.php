<?php

namespace App\Http\Controllers;

use App\Models\TripFlight;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TripFlightController extends Controller
{
    /**
     * Display a listing of the departure flight.
     */
    public function index(Trip $trip)
    {
        $data = [
            'departure_flights' => $trip->departure_flight,
            'return_flights' => $trip->return_flight
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the departure flight.
     */
    public function index_departure(Trip $trip)
    {
        $data = [
            'departure_flights' => $trip->departure_flight
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the return flight.
     */
    public function index_return(Trip $trip)
    {
        $data = [
            'return_flights' => $trip->return_flight
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Trip $trip)
    {
        $attributes = $this->validateTripFlight();

        $flight_type = $attributes['type'] . '_flight';

        $existing_flight = $trip->$flight_type()->where('flight_index', '>=', $attributes["flight_index"] )->orderBy('flight_index')->get();
        $trip_flight = $trip->$flight_type()->create($attributes);

        foreach ($existing_flight as &$flight)
        {
            $current_flight_index = $flight['flight_index'];
            $flight->update([
                'flight_index' => $current_flight_index + 1
            ]);
        }

        $data = [
            'trip_flight' => $trip_flight
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip, TripFlight $tripFlight)
    {
        // Check that trip and trip flight match
        if($trip->id === $tripFlight->trip_id)
        {
            $data = [
                'trip_flight' => $tripFlight
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Flight'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip, TripFlight $tripFlight)
    {
        // Check that trip and trip flight match
        if($trip->id === $tripFlight->trip_id)
        {
            $attributes = $this->validateTripFlight($tripFlight);

            if($attributes['flight_index'] !== $tripFlight->flight_index)
            {
                // Reorganize flight
                $method = "reorganize_" . $tripFlight->type . "_flights";
                $this->$method($trip, $tripFlight->flight_index, $attributes['flight_index']);
            }

            $tripFlight->update($attributes);
            
            $data = [
                'trip_flight' => $tripFlight
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Flight'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip, TripFlight $tripFlight)
    {
        // Check that trip and trip flight match
        if($trip->id === $tripFlight->trip_id)
        {
            $tripFlight->delete();

            $data = [
                'message' => 'Trip Flight destroyed successfully.'
            ];

            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Trip Flight'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Display a listing of ALL flights.
     */
    public function list_all_flights()
    {
        $departure_flights = TripFlight::where('type', '=', 'departure')->with('trip:id,type,title')->get();
        $return_flights = TripFlight::where('type', '=', 'return')->with('trip:id,type,title')->get();

        $data = [
            'departure_flights' => $departure_flights,
            'return_flights' => $return_flights
        ];

        return response()->json($data);
    }

    function validateTripFlight(?TripFlight $trip_flight = null): array
    {
        $trip_flight ??= new TripFlight();

        return $attributes = request()->validate([
            'flight_index' => 'required',
            'type' => ['required', Rule::in(['departure','return'])],
            'airline' => 'required',
            'airline_code' => 'required',
            'airline_flight_number' => 'required',
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id',
            'departure_date' => 'required|date',
            'departure_time' => 'date_format:H:i',
            'arrival_date' => 'required|date',
            'arrival_time' => 'date_format:H:i',
        ]);
    }

    function reorganize_departure_flights(Trip $trip, int $ignore_flight_index, int $new_flight_index)
    {
        $beginning_departure_flight =  $trip->departure_flight()
                                    ->where('flight_index', '<=', $new_flight_index)
                                    ->where('flight_index', '<>', $ignore_flight_index)
                                    ->orderBy('flight_index')
                                    ->get();
        
        $starting_index = 1;
        foreach ($beginning_departure_flight as &$departure_flight)
        {
            $departure_flight->update([
                'flight_index' => $starting_index
            ]);

            $starting_index++;
        }

        $ending_departure_flight =     $trip->departure_flight()
                                    ->where('flight_index', '>=', $new_flight_index)
                                    ->where('flight_index', '<>', $ignore_flight_index)
                                    ->orderBy('flight_index')
                                    ->get();

        $starting_index = $new_flight_index + 1;
        foreach ($ending_departure_flight as &$departure_flight)
        {
            $departure_flight->update([
                'flight_index' => $starting_index
            ]);

            $starting_index++;
        }
    }

    function reorganize_return_flights(Trip $trip, int $ignore_flight_index, int $new_flight_index)
    {
        $beginning_return_flight =  $trip->return_flight()
                                    ->where('flight_index', '<=', $new_flight_index)
                                    ->where('flight_index', '<>', $ignore_flight_index)
                                    ->orderBy('flight_index')
                                    ->get();
        
        $starting_index = 1;
        foreach ($beginning_return_flight as &$return_flight)
        {
            $return_flight->update([
                'flight_index' => $starting_index
            ]);

            $starting_index++;
        }

        $ending_return_flight =     $trip->return_flight()
                                    ->where('flight_index', '>=', $new_flight_index)
                                    ->where('flight_index', '<>', $ignore_flight_index)
                                    ->orderBy('flight_index')
                                    ->get();

        $starting_index = $new_flight_index + 1;
        foreach ($ending_return_flight as &$return_flight)
        {
            $return_flight->update([
                'flight_index' => $starting_index
            ]);

            $starting_index++;
        }
    }
}
