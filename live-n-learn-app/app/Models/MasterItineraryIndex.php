<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterItineraryIndex extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'itinerary_index',
        'itinerary_date',
        'time',
        'title',
        'content',
        'media_file_id'
    ];

    protected $with = [
        'media_file'
    ];


    /**
     * Get the parent that owns the MasterItineraryIndex
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(MasterItinerary::class);
    }
    
    /**
     * Get the media_file associated with the TripItinerary.
     */
    public function media_file()
    {
        return $this->belongsTo(MediaFile::class, 'media_file_id');
    }
}
