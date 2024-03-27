<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripFlight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trip_id',
        'flight_index',
        'type',
        'airline',
        'airline_code',
        'airline_flight_number',
        'origin_airport_id',
        'destination_airport_id',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time'
    ];

    protected $with = [
        'origin_airport',
        'destination_airport'
    ];

    /**
     * Get the trip that owns the TripFlight
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Get the origin_airport that owns the TripFlight
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function origin_airport()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    /**
     * Get the destination_airport that owns the TripFlight
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destination_airport()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }
}
