<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TripUserCancellationInsurance;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'recipient_id',
        'created_by_id',
        'trip_id',
        'due_date',
        'comments',
        'deleted_by_id',
        'payment_plan_type',
        'payment_method_type',
        'default_payment_method_id'
    ];

    protected $with = [
        'invoice_items',
        'additional_invoice_items',
        'invoice_payments',
        'recipient',
        'created_by'
    ];

    protected $appends = [
        'subtotal',
        'total',
        'amount_paid',
        'amount_due',
        'invoice_number',
        'issue_date',
        'deposit_amount'
    ];

    /**
     * Get all of the invoice_items for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id')->where('invoice_items.primary', 1);
    }

    /**
     * Get all of the additional_invoice_items for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function additional_invoice_items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id')->where('invoice_items.primary', 0);
    }

    /**
     * Get all of the invoice_payments for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id');
    }

    /**
     * Get all of the payment_plan for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment_plan()
    {
        return $this->hasMany(InvoicePaymentPlan::class, 'invoice_id');
    }

    /**
     * Get the trip that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Get the recipient that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Get the created_by that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get the invoice number.
     *
     * @param  string  $value
     * @return void
     */
    public function getInvoiceNumberAttribute()
    {
        return sprintf("%010d", $this->id);
    }

    /**
     * Get the subtotal of the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getSubtotalAttribute()
    {
        return round($this->invoice_items->sum('line_total'), 2);
    }

    /**
     * Get the total of the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getTotalAttribute()
    {
        return round($this->getSubtotalAttribute() + $this->additional_invoice_items->sum('line_total'), 2);
    }

    /**
     * Get the amount_paid on the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getAmountPaidAttribute()
    {
        return round($this->invoice_payments->sum('amount'), 2);
    }

    /**
     * Get the amount_due on the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getAmountDueAttribute()
    {
        $amount_due = $this->getTotalAttribute() - $this->getAmountPaidAttribute();

        return round($amount_due, 2);
    }

    /**
     * Get the issue_date on the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getIssueDateAttribute()
    {
        $issue_date = $this->created_at->format('Y-m-d');

        return $issue_date;
    }

    /**
     * Get the deposit_amount on the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getDepositAmountAttribute()
    {
        $selectedInsuranceOption = TripUserCancellationInsurance::where('user_id', $this->recipient_id)
                                    ->where('trip_id', $this->trip_id)->first();

        $insurance_cost = $selectedInsuranceOption ? $selectedInsuranceOption->amount : 0;

        // Check that the amount if valid
        $deposit_amount = 250 + $insurance_cost;

        return $deposit_amount;
    }
}
