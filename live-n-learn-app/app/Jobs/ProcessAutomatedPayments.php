<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\InvoicePaymentPlan;
use App\Models\UserPaymentMethod;
use Carbon\Carbon;

use App\Services\Stripe;

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
        $stripe = new Stripe();
        $today = Carbon::today();
        $fee_percentage = 0.03;

        $invoice_payment_plans = InvoicePaymentPlan::whereDate('scheduled_payment_date', $today->toDateString())->whereNull('stripe_payment_intent_id')->get();

        // Loop through each payment plan
        foreach($invoice_payment_plans as &$payment_plan)
        {
            $invoice = $payment_plan->invoice;

            if($invoice->payment_plan_type != 'automated') continue;

            // Get the payment method
            $payment_method_id = $invoice->default_payment_method_id;
            $payment_method = UserPaymentMethod::find($payment_method_id);

            $payment_method_type    = str_starts_with($stripe_payment_method_id, 'ca_')
                                    ? 'credit'
                                    : (
                                        str_starts_with($stripe_payment_method_id, 'ba_')
                                        ? 'ach'
                                        : 'other'
                                    );

            $stripe_customer_id = $payment_method->user->stripe_customer_id;
            $stripe_payment_method_id = $payment_method->stripe_payment_method_id;

            $payment_amount = $payment_plan->amount;
            if($payment_amount > $invoice->amount_due) $payment_amount = $invoice->amount_due;

            $fees = ($payment_method_type == 'credit') ? $payment_amount * $fee_percentage : 0;

            $total_amount = $payment_amount + $fees;
        
            $amount_in_cents = $total_amount * 100;

            // Trigger payment
            $payment_intent = $stripe->makePayment($stripe_customer_id, $stripe_payment_method_id, $amount_in_cents);
    
            // Store payment into payment plan
            $payment_plan->update(['stripe_payment_intent_id' => $payment_intent['id']]);
    
            // Store payment into invoice payments
            $invoice->invoice_payments()->create([
                'payment_method' => $payment_method_type,
                'stripe_payment_intent_id' => $payment_intent['id'],
                'date' => $today,
                'amount' => $payment_amount,
                'fees' => $fees,
                'notes' => "Automated Payment"
            ]);
        }
    }
}
