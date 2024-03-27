<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'address_1',
        'address_2',
        'city',
        'state_province',
        'postal_code',
        'country_code',
        'country_phone_code',
        'phone_number'
    ];


    /**
     * Get the Trips linked to the Partner
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class, 'partner_id');
    }
}
