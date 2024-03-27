<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'address_1',
        'address_2',
        'city',
        'state_province',
        'postal_code',
        'country_code'
    ];

    /**
     * Get the Trips linked to the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class, 'school_id');
    }

}
