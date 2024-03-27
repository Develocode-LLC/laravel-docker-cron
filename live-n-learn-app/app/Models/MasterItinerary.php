<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItinerary extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'title',
        'description'
    ];

    protected $with = [
        'overview',
        'images',
        'destinations'
    ];

    /**
     * Get the MasterItineraryIndexes linked to the MasterItinerary
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function overview()
    {
        return $this->hasMany(MasterItineraryIndex::class, 'master_itinerary_id');
    }
    
    /**
     * Get the MasterItineraryIndexes linked to the MasterItinerary
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function images()
    {
        return $this->hasMany(MasterItineraryImage::class, 'master_itinerary_id');
    }

    /**
     * Get the Destination Locations that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function destinations()
    {
        return $this->belongsToMany(Location::class, 'master_itinerary_destinations');
    }
}
