<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMedicalInformation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'has_special_accommodations',
        'special_accommodations_details',
        'has_preexisting_conditions',
        'preexisting_conditions_details',
        'preexisting_conditions_warning_sign',
        'has_allergies',
        'allergies_details',
        'allergic_reaction_details',
        'has_dietary_restrictions',
        'dietary_restriction_details',
        'has_prescription_medications',
        'prescription_medications_details',
        'has_otc_medications',
        'otc_medications_details',
        'has_additional_information',
        'additional_information_details',
        'diet',
        'diet_details',
    ];
    
    protected $hidden = [
        'diet',
    ];

    protected $appends = [
        'user_diet',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserDietAttribute()
    {
        $value = $this->diet;

        $diet_array = array_filter(explode(",",$value));

        return $diet_array;
    }
}
