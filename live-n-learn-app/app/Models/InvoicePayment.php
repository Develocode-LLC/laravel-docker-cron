<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_payment_method_id',
        'stripe_payment_intent_id',
        'payment_method',
        'date',
        'amount',
        'fees',
        'notes',
    ];

    protected $appends = [
        'amount_with_fees',
    ];

    /**
     * Get the invoice that owns the InvoicePayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the total of the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getAmountWithFeesAttribute()
    {
        return round($this->amount + $this->fees, 2);
    }
}
