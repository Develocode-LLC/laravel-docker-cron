<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'deleted_by_id'
    ];

    protected $with = [
        'invoice_items',
        'invoice_payments',
        'recipient',
        'created_by'
    ];

    protected $appends = [
        'subtotal',
        'amount_paid',
        'amount_due',
        'invoice_number',
        'issue_date'
    ];

    /**
     * Get all of the invoice_items for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
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
        return $this->invoice_items->sum('line_total');
    }

    /**
     * Get the amount_paid on the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getAmountPaidAttribute()
    {
        return $this->invoice_payments->sum('amount');
    }

    /**
     * Get the amount_due on the Invoice.
     *
     * @param  string  $value
     * @return void
     */
    public function getAmountDueAttribute()
    {
        $amount_due = $this->getSubtotalAttribute() - $this->getAmountPaidAttribute();

        return $amount_due;
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
}
