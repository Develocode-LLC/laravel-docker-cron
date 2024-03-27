<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'school_id',
        'partner_id',
        'code',
        'title',
        'description',
        'start_date',
        'end_date',
        'registration_cutoff_date',
        'min_available_seats',
        'max_available_seats',
        'total_cost',
        'basic_cost',
        'elite_cost',
        'origination_location_id',
    ];

    protected $with = [
        'origination',
        'destinations',
        'travelers',
        'host_families',
        'local_coordinators',
        'group_leaders',
        'itinerary',
        'images',
        'departure_flight',
        'return_flight'
    ];

    /**
     * Get the Origination Location that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function origination()
    {
        return $this->belongsTo(Location::class, 'origination_location_id');
    }

    /**
     * Get the Destination Locations that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function destinations()
    {
        return $this->belongsToMany(Location::class, 'trip_destinations');
    }

    /**
     * The users that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'trip_user');
    }

    /**
     * The school that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function school()
    {
        return $this->belongsToMany(School::class, 'school_id');
    }

    /**
     * The partner that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partner()
    {
        return $this->belongsToMany(School::class, 'partner_id');
    }

    /**
     * The travelers that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function travelers()
    {
        return $this->belongsToMany(User::class, 'trip_user')->wherePivot('users.class', 'traveler');
    }

    /**
     * The host_families that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function host_families()
    {
        return $this->belongsToMany(User::class, 'trip_user')->wherePivot('users.class', 'host_family');
    }

    /**
     * The local_coordinators that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function local_coordinators()
    {
        return $this->belongsToMany(User::class, 'trip_user')->wherePivot('users.class', 'local_coordinator');
    }

    /**
     * The group_leaders that belong to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function group_leaders()
    {
        return $this->belongsToMany(User::class, 'trip_user')->wherePivot('users.class', 'group_leader');
    }

    /**
     * Get all of the itinerary for the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itinerary()
    {
        return $this->hasMany(TripItinerary::class, 'trip_id');
    }

    /**
     * Get the images linked to the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function images()
    {
        return $this->hasMany(TripImage::class, 'trip_id');
    }

    /**
     * Get all of the departure_flight for the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departure_flight()
    {
        return $this->hasMany(TripFlight::class, 'trip_id')->where('trip_flights.type', 'departure');
    }

    /**
     * Get all of the return_flight for the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function return_flight()
    {
        return $this->hasMany(TripFlight::class, 'trip_id')->where('trip_flights.type', 'return');
    }
}
