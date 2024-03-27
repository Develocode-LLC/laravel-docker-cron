<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airports = Airport::get();

        $data = [
            'airports' => $airports
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Airport $airport)
    {
        $data = [
            'airport' => $airport
        ];

        return response()->json($data);
    }


    /**
     * Display a listing of the resource filtered by location.
     */
    public function index_by_location(string $country, ?string $city = null)
    {
        $query = [
            [ 'country', $country ]
        ];

        if(!empty($city))
        {
            $city_query = [ 'city', 'like', "$city%" ];
            array_push( $query, $city_query);
        }

        $airports = Airport::where($query)->get();

        $data = [
            'airports' => $airports
        ];

        return response()->json($data);
    }


    /**
     * Display a listing of the resource filtered by location.
     */
    public function index_by_city(string $city)
    {
        
        $airports = Airport::where('city', 'like', "$city%")->get();

        $data = [
            'airports' => $airports
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the available countries.
     */
    public function list_available_countries()
    {
        $countries = Airport::select('country')->distinct()->get();

        $data = [
            'countries' => $countries
        ];

        return response()->json($data);
    }
    
    /**
     * Look Up a Airport by the assigned code
     */
    public function code_lookup(string $code)
    {
        $airports = Airport::where('code', $code)->get();

        $data = [
            'airports' => $airports
        ];

        return response()->json($data);
    }

}
