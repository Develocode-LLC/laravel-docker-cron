<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class FormSignature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trip_id',
        'user_id',
        'form_type',
        'signature_file_location',
        'name',
        'signature_date',
        'signature_type'
    ];

    protected $appends = [
        'signature_uri',
    ];
    
    public function getSignatureUriAttribute()
    {
        $value = $this->signature_file_location;

        if (!empty($value) && Storage::exists($value))
        {
            $aws_file_location = Storage::temporaryUrl($value, now()->addMinutes(30));

            return $aws_file_location;
        }

        return;
    }

    /**
     * Get the user that owns the Form Signature
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the trip that owns the Form Signature
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
