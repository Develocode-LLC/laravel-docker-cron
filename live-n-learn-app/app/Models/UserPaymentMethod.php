<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Services\Stripe;

class UserPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'stripe_payment_method_id',
        'requires_verification'
    ];

    protected $appends = [
        'stripe_object'
    ];

    /**
     * Get the stripe object.
     *
     * @param  string  $value
     * @return void
     */
    public function getStripeObjectAttribute()
    {
        $stripe_payment_method_obj;
        $stripe = new Stripe();

        if($this->requires_verification)
        {
            if(str_starts_with($this->stripe_payment_method_id, 'ba_'))
            {
                $stripe_payment_method_obj = $stripe->getBankAccount(
                    $this->user,
                    $this->stripe_payment_method_id
                );
            }
        }
        else
        {
            $stripe_payment_method_obj = $stripe->getPaymentMethod(
                $this->user,
                $this->stripe_payment_method_id
            );
        }
        
        return $stripe_payment_method_obj;
    }

    /**
     * Get the user that owns the UserPaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
