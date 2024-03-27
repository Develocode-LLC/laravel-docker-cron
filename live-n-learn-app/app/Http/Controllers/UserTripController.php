<?php

namespace App\Http\Controllers;

use DateTimeImmutable;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationKey;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Trip;
use App\Models\Role;

class UserTripController extends Controller
{
    public function trip_registration(Request $request, Trip $trip)
    {
        $invoice;
        $today = new DateTimeImmutable();
        $cut_off_date = new DateTimeImmutable($trip->registration_cutoff_date);

        $travelers_count = count($trip->travelers);

        if($today > $cut_off_date)
        {
            $error = [
                'message' => 'Invalid trip',
            ];

            return response()->json($error, 422);
        }

        if($travelers_count + 1 > $trip->max_available_seats)
        {
            $error = [
                'message' => 'Not enough available seats',
            ];

            return response()->json($error, 422);
        }

        $attributes = $this->validateRegistration();

        $traveler_request = $attributes['traveler'];
        $parent_guardian_request = $attributes['parent_guardian'];

        // Set some defaults
        $parent_guardian_request['class'] = 'parent';
        $parent_guardian_request['password'] = '';
        $parent_role = Role::where('key', 'parent')->get();

        // Create Parent Account
        User::upsert($parent_guardian_request, ['email'], ['first_name', 'last_name', 'phone_number']);
        $parent_guardian = User::where('email', $parent_guardian_request['email'])->first();

        // Create Traveler Account
        $traveler_request['class'] = 'traveler';
        $traveler_request['password'] = '';
        $traveler_request['parent_user_id'] = $parent_guardian->id;
        $traveler_request['school_id'] = $trip->school_id;
        $traveler_role = Role::where('key', 'traveler')->get();

        User::upsert($traveler_request, ['email'], ['first_name', 'last_name', 'phone_number', 'school_id']);
        $traveler = User::where('email', $traveler_request['email'])->first();

        $this->generate_account_number($traveler);

        // Assign user to trip
        $hasUser = $trip->users()->where('user_id', $traveler->id)->exists();

        if(!$hasUser)
        {
            $trip->users()->attach($traveler);
            $invoice = $this->generate_invoice($traveler, $trip);
        }
        
        $data = [
            'message' => 'Trip Registration Successful',
        ];

        // Send Registration email if they haven't registered
        if (!$traveler->has_registered && !$traveler->registration_key)
        {
            $this->generate_registration_key($traveler);
            Mail::to($traveler)->send(new UserRegistrationKey($traveler));
        }

        if (!$parent_guardian->has_registered && !$parent_guardian->registration_key)
        {
            $this->generate_registration_key($parent_guardian);
            Mail::to($parent_guardian)->send(new UserRegistrationKey($parent_guardian));
        }

        return response()->json($data);
    }

    public function email_test(User $user)
    {
        return new UserRegistrationKey($user);
    }

    public function generate_invoice(User $user, Trip $trip)
    {
        $trip_date = $trip->start_date;
        $trip_date = new DateTimeImmutable($trip->start_date);
        $invoice_due_date = $trip_date->modify('-110 days');
        
        $attributes = array(
            'uuid' => (string) Str::uuid(),
            'trip_id' => $trip->id,
            'recipient_id' => $user->id,
            'due_date' => $invoice_due_date->format('Y-m-d'),
            'invoice_items' => array(
                array(
                    'name' => 'Trip Cost',
                    'line_total' => $trip->total_cost
                ),
            )
        );

        $invoice = Invoice::create($attributes);

        foreach ($attributes['invoice_items'] as &$invoice_item)
        {
            $invoice->invoice_items()->create($invoice_item);
        }

        return $invoice;
    }

    /**
     * Create random string
     */
    private function _random_characters(int $length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Generate the account code
     */
    private function generate_account_number(User $user)
    {
        $user_account_number = '';
        $user_count = 0;

        if($user->account_number) return;

        do {
            $user_account_number = $this->_random_characters(10);

            $user_count = User::where('account_number', '=', $user_account_number)->count();

        } while($user_count > 0 );

        $user->update([
            'account_number' => $user_account_number
        ]);

        return;
    }

    /**
     * Generate the registration key
     */
    private function generate_registration_key(User $user)
    {
        $registration_key = '';
        $user_count = 0;

        if($user->registration_key) return;

        do {
            $registration_key = Str::upper(Str::password(16, true, true, false, false));

            $user_count = User::where('registration_key', '=', $registration_key)->count();

        } while($user_count > 0 );

        $user->update([
            'registration_key' => $registration_key
        ]);

        return;
    }

    function validateRegistration(): array
    {
        return $attributes = request()->validate([
            'traveler.first_name' => 'required',
            'traveler.last_name' => 'required',
            'traveler.email' => 'required|confirmed|different:parent_guardian.email',
            'traveler.phone_number' => 'nullable',

            'parent_guardian.first_name' => 'required',
            'parent_guardian.last_name' => 'required',
            'parent_guardian.email' => 'required|confirmed|different:traveler.email',
            'parent_guardian.phone_number' => 'nullable'
        ]);
    }
}
