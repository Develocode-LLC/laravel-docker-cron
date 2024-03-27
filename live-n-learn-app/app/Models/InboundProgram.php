<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InboundProgram extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'location_id',
        'partner_id',
        'origin_country',
        'national_language',
        'available_seats',
        'start_date',
        'end_date',
        'deleted_by_id',
    ];

    protected $with = [
        'program_location',
        'inbound_partner',
        'travelers',
        'host_families',
        'local_coordinators',
        'departure_flight',
        'return_flight'
    ];

    /**
     * Get the location that owns the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program_location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the partner that owns the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inbound_partner()
    {
        return $this->belongsTo(Location::class, 'partner_id');
    }

    /**
     * The users that belong to the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'inbound_program_users');
    }

    /**
     * The travelers that belong to the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function travelers()
    {
        return $this->belongsToMany(User::class, 'inbound_program_users')->wherePivot('users.class', 'traveler');
    }

    /**
     * The host_families that belong to the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function host_families()
    {
        return $this->belongsToMany(User::class, 'inbound_program_users')->wherePivot('users.class', 'host_family');
    }

    /**
     * The local_coordinators that belong to the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function local_coordinators()
    {
        return $this->belongsToMany(User::class, 'inbound_program_users')->wherePivot('users.class', 'local_coordinator');
    }

    /**
     * Get all of the departure_flight for the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departure_flight()
    {
        return $this->hasMany(InboundProgramFlight::class, 'inbound_program_id')->where('inbound_program_flights.type', 'departure');
    }

    /**
     * Get all of the return_flight for the InboundProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function return_flight()
    {
        return $this->hasMany(InboundProgramFlight::class, 'inbound_program_id')->where('inbound_program_flights.type', 'return');
    }
}
