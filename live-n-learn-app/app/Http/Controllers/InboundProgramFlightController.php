<?php

namespace App\Http\Controllers;

use App\Models\InboundProgramFlight;
use App\Models\InboundProgram;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InboundProgramFlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InboundProgram $inboundProgram)
    {
        $data = [
            'departure_flights' => $inboundProgram->departure_flight,
            'return_flights' => $inboundProgram->return_flight
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the departure flight.
     */
    public function index_departure(InboundProgram $inboundProgram)
    {
        $data = [
            'departure_flights' => $inboundProgram->departure_flight
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the return flight.
     */
    public function index_return(InboundProgram $inboundProgram)
    {
        $data = [
            'return_flights' => $inboundProgram->return_flight
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, InboundProgram $inboundProgram)
    {
        $attributes = $this->validateInboundProgramFlight();

        $flight_type = $attributes['type'] . '_flight';

        $existing_flight = $inboundProgram->$flight_type()->where('flight_index', '>=', $attributes["flight_index"] )->orderBy('flight_index')->get();
        $program_flight = $inboundProgram->$flight_type()->create($attributes);

        foreach ($existing_flight as &$flight)
        {
            $current_flight_index = $flight['flight_index'];
            $flight->update([
                'flight_index' => $current_flight_index + 1
            ]);
        }

        $data = [
            'inbound_program_flight' => $program_flight
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(InboundProgram $inboundProgram, InboundProgramFlight $inboundProgramFlight)
    {
        // Check that program and program flight match
        if($inboundProgram->id === $inboundProgramFlight->inbound_program_id)
        {
            $data = [
                'inbound_program_flight' => $inboundProgramFlight
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Inbound Program Flight'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InboundProgram $inboundProgram, InboundProgramFlight $inboundProgramFlight)
    {
        // Check that program and program flight match
        if($inboundProgram->id === $inboundProgramFlight->inbound_program_id)
        {
            $attributes = $this->validateInboundProgramFlight($inboundProgramFlight);

            if($attributes['flight_index'] !== $inboundProgramFlight->flight_index)
            {
                // Reorganize flight
                $method = "reorganize_" . $inboundProgramFlight->type . "_flights";
                $this->$method($inboundProgram, $inboundProgramFlight->flight_index, $attributes['flight_index']);
            }

            $inboundProgramFlight->update($attributes);
            
            $data = [
                'inbound_program_flight' => $inboundProgramFlight
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Inbound Program Flight'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InboundProgram $inboundProgram, InboundProgramFlight $inboundProgramFlight)
    {
        // Check that program and program flight match
        if($inboundProgram->id === $inboundProgramFlight->inbound_program_id)
        {
            $inboundProgramFlight->delete();

            $data = [
                'message' => 'Inbound Program Flight destroyed successfully.'
            ];

            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Inbound Program Flight'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Display a listing of ALL flights.
     */
    public function list_all_flights()
    {
        $departure_flights = InboundProgramFlight::where('type', '=', 'departure')->with('inbound_program')->get();
        $return_flights = InboundProgramFlight::where('type', '=', 'return')->with('inbound_program')->get();

        $data = [
            'departure_flights' => $departure_flights,
            'return_flights' => $return_flights
        ];

        return response()->json($data);
    }

    function validateInboundProgramFlight(?InboundProgramFlight $inboundProgramFlight = null): array
    {
        $inboundProgramFlight ??= new InboundProgramFlight();

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


    function reorganize_departure_flights(InboundProgram $inboundProgram, int $ignore_flight_index, int $new_flight_index)
    {
        $beginning_departure_flight =  $inboundProgram->departure_flight()
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

        $ending_departure_flight =     $inboundProgram->departure_flight()
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

    function reorganize_return_flights(InboundProgram $inboundProgram, int $ignore_flight_index, int $new_flight_index)
    {
        $beginning_return_flight =  $inboundProgram->return_flight()
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

        $ending_return_flight =     $inboundProgram->return_flight()
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
