<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class',
        'registration_key',
        'has_registered',
        'account_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'phone_number',
        't_shirt_size',
        'gender',
        'gender_identity',
        'passport_file_location',
        'passport_issue_date',
        'passport_expiration_date',
        'health_medical_information',
        'dietary_preferences',
        'follows_diet',
        'eats_seafood',
        'rides_bike',
        'stripe_customer_id',
        'parent_user_id',
        'address_1',
        'address_2',
        'city',
        'state_province',
        'postal_code',
        'country_code',
        'preferred_pronouns',
        'preferred_pronouns_other',
        'school_id',
        'grade',
        'host_family_request',
        'college_credit',
        'scholarships',
        'previously_hosted',
        'previously_hosted_year',
        'default_payment_method_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'passport_uri',
        'full_name',
    ];
    
    public function getPassportUriAttribute()
    {
        $value = $this->passport_file_location;

        if (!empty($value) && Storage::exists($value))
        {
            $aws_file_location = Storage::temporaryUrl($value, now()->addHours(24));

            return $aws_file_location;
        }

        return;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getFullNameAttribute()
    {
       return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get all of the metadata for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    /**
     * Get all of the media_files for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media_files()
    {
        return $this->hasMany(UserMediaFile::class, 'user_id');
    }

    /**
     * Get all of the media_files for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips()
    {
        $date = Carbon::today();
        return $this->belongsToMany(Trip::class, 'trip_user')->wherePivot('trips.end_date', '>=', $date);
    }

    /**
     * Get all of the payment_methods for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment_methods()
    {
        return $this->hasMany(UserPaymentMethod::class, 'user_id');
    }

    /**
     * Get all of the contacts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(UserContact::class, 'user_id');
    }

    /**
     * Get all of the payment_methods for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    /**
     * Get all of the children for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_user_id');
    }

    /**
     * Get the medical_information associated with the user.
     */
    public function medical_information()
    {
        return $this->hasOne(UserMedicalInformation::class);
    }

}
