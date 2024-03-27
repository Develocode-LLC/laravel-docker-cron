<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\InvoicePaymentPlan;
use Carbon\Carbon;

class ProcessAutomatedPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = Carbon::today();
        $invoice_payment_plans = InvoicePaymentPlan::whereDate('scheduled_payment_date', $today)
                                    ->whereNull('stripe_payment_intent_id')->get();

        // Loop through each payment plan

        // Get the payment method

        // Trigger payment

        // Store payment into payment plan

        // Store payment into invoice payments
    }
}
