<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'file_location'
    ];

    protected $appends = [
        'uri'
    ];

    /**
     * Get the media file's image file location.
     *
     * @param  string  $value
     * @return void
     */
    public function getUriAttribute()
    {
        $value = $this->file_location;

        if (!empty($value) && Storage::exists($value))
        {
            $aws_file_location = Storage::temporaryUrl($value, now()->addHours(24));
            return $aws_file_location;
        }

        return;
    }

}
