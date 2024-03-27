<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Services\Stripe;

class InvoicePaymentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'scheduled_payment_date',
        'amount',
        'stripe_payment_intent_id'
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
        $stripe = new Stripe();

        if(!$this->stripe_payment_intent_id) return;

        $stripe_payment_intent_obj = $stripe->getPaymentIntent(
            $this->stripe_payment_intent_id
        );

        return $stripe_payment_intent_obj;
    }

    /**
     * Get the invoice that owns the InvoicePaymentPlan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
