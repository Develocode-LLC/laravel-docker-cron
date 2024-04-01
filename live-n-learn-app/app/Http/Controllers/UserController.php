<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserMeta;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use App\Services\Stripe;

class UserController extends Controller
{

    private $class_array = [
        'administrator',
        'host_family',
        'local_coordinator',
        'group_leader',
        'traveler',
        'inbound_partner',
        'outbound_partner'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->has('class'))
        {
            $class = request()->input('class');
            $users = User::latest()->where('class', $class)->get();
        }
        else
        {
            $users = User::latest()->get();
        }

        $data = [
            'users' => $users,
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stripe = new Stripe();

        $attributes = $this->validateNewUser();
        $metadata_array = $request->metadata;

        $user = User::create($attributes);

        if($request->contacts)
        {
            $contacts_attributes = $this->validateContacts();
            $user->contacts()->createMany($contacts_attributes['contacts']);
        }

        if($user->class === 'traveler') $this->generate_account_number($user);
        if(in_array($user->class, ['parent', 'traveler'])) $stripe->createCustomer($user);
        
        foreach($metadata_array as &$metadata)
        {
            $metadata['user_id'] = $user->id;
        }


        UserMeta::query()->where('user_id', $user->id)->upsert($metadata_array, ['user_id', 'key'], ['value']);

        $user->refresh();

        $data = [
            "user" => $user
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['metadata', 'contacts'])->find($id);

        if($user->class == 'parent')
        {
            $children = User::where('parent_user_id', $id)->get();
            $user['children'] = $children;
        }

        $data = [
            "user" => $user
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show_with_trips(string $id)
    {
        $user = User::with(['metadata', 'trips'])->find($id);

        if($user->class == 'parent')
        {
            $children = User::with(['trips'])->where('parent_user_id', $id)->get();
            $user['children'] = $children;
        }

        $data = [
            "user" => $user
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show_with_parent(string $id)
    {
        $user = User::with(['metadata', 'contacts', 'parent'])->find($id);

        $data = [
            "user" => $user
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stripe = new Stripe();

        $user = User::with(['metadata','contacts'])->find($id);
        $metadata_array = $request->metadata;
        
        $attributes = $this->validateExistingUser($user);

        $user->update($attributes);
        
        if($user->class === 'traveler') $this->generate_account_number($user);

        foreach($metadata_array as &$metadata)
        {
            $metadata['user_id'] = $id;
        }

        UserMeta::query()->where('user_id', $id)->upsert($metadata_array, ['user_id', 'key'], ['value']);

        if($request->contacts)
        {
            $contacts_attributes = $this->validateContacts();

            if($user->contacts) $user->contacts()->delete();
            $user->contacts()->createMany($contacts_attributes['contacts']);
        }

        $user->refresh();

        if(in_array($user->class, ['parent', 'traveler']))
        {
            if($user->stripe_customer_id)
            {
                $stripe->updateCustomer($user);
            }
            else
            {
                $stripe->createCustomer($user);
            }
        }

        $data = [
            "user" => $user
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to delete from users'
            ];
            return response()->json($error, 422);
        }

        if($user->class == 'administrator')
        {
            $error = [
                'message' => 'Admins cannot be deleted'
            ];
            return response()->json($error, 422);
        }
        
        $user->delete();

        $data = [
            'message' => 'User destroyed successfully.'
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function profile(Request $request)
    {
        $auth_user = Auth::user();

        $data = [
            'user' => $auth_user,
        ];

        return response()->json($data);
    }

    /**
     * Initiate Forgot Password
     */
    public function forgot_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        $data = [
            'user' => request()->user(),
        ];
        
        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['sussess' => true, 'message' => __($status)])
                    : response()->json(['success' => false, 'message' => __($status)], 422);
    }

    /**
     * Reset Password
     */
    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? response()->json(['sussess' => true, 'message' => __($status)])
                    : response()->json(['success' => false, 'message' => __($status)], 422);
    }

    /**
     * Function to upload the user's passport
     */
    public function upload_passport(Request $request, User $user)
    {
        $auth_user = Auth::user();

        $is_same_user = ($auth_user->id === $user->id);
        $isnot_same_user_but_admin = ($auth_user->id !== $user->id && $auth_user->class == 'administrator');

        if(!$is_same_user && !$isnot_same_user_but_admin)
        {
            $error = [
                'message' => 'Passport could not be updated'
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validatePassportData();

        if($request->hasFile('passport'))
        {
            $passport_file = $request->file('passport');

            if($passport_file->isValid())
            {
                $file_path = Storage::put("user/{$user->id}/files", $passport_file);

                $attributes['passport_file_location'] = $file_path;
            }
        }
        
        $user->update($attributes);
        
        $data = [
            'user' => $user
        ];

        return response()->json($data);
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

    function validateNewUser(): array
    {
        return $attributes = request()->validate([
            'class' => ['required', Rule::in($this->class_array)],
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => ['required', 'confirmed', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:8',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable',
            't_shirt_size' => 'nullable',
            'gender' => 'nullable',
            'gender_identity' => 'nullable',
            'passport_issue_date' => 'nullable|date|before:today',
            'passport_expiration_date' => 'nullable|date|after:tomorrow',
            'health_medical_information' => 'nullable',
            'dietary_preferences' => 'nullable',
            'follows_diet' => 'nullable',
            'eats_seafood' => 'nullable',
            'rides_bike' => 'nullable|integer',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'city' => 'nullable',
            'state_province' => 'nullable',
            'postal_code' => 'nullable',
            'country_code' => 'nullable',
            'preferred_pronouns' => 'nullable',
            'preferred_pronouns_other' => 'nullable',
            'school_id' => 'nullable|exists:locations,id',
            'grade' => ['nullable', Rule::in(['7', '8', '9', '10', '11', '12'])],
            'host_family_request' => 'nullable',
            'college_credit' => 'nullable',
            'scholarships' => 'nullable',
            'previously_hosted' => 'nullable',
            'previously_hosted_year' => 'nullable|integer',
        ]);
    }

    function validateExistingUser(?User $user = null): array
    {
        $user ??= new User();

        return $attributes = request()->validate([
            'class' => ['required', Rule::in($this->class_array)],
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => ['required', 'confirmed', Rule::unique('users', 'email')->ignore($user->id)],
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable',
            't_shirt_size' => 'nullable',
            'gender' => 'nullable',
            'gender_identity' => 'nullable',
            'passport_issue_date' => 'nullable|date|before:today',
            'passport_expiration_date' => 'nullable|date|after:tomorrow',
            'health_medical_information' => 'nullable',
            'dietary_preferences' => 'nullable',
            'follows_diet' => 'nullable',
            'eats_seafood' => 'nullable',
            'rides_bike' => 'nullable|integer',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'city' => 'nullable',
            'state_province' => 'nullable',
            'postal_code' => 'nullable',
            'country_code' => 'nullable',
            'preferred_pronouns' => 'nullable',
            'preferred_pronouns_other' => 'nullable',
            'school_id' => 'nullable|exists:locations,id',
            'grade' => ['nullable', Rule::in(['7', '8', '9', '10', '11', '12'])],
            'host_family_request' => 'nullable',
            'college_credit' => 'nullable',
            'scholarships' => 'nullable',
            'previously_hosted' => 'nullable',
            'previously_hosted_year' => 'nullable|integer',
        ]);
    }

    function validateContacts(): array
    {
        return $attributes = request()->validate([
            'contacts' => 'nullable|array',
            'contacts.*.contact_type' => ['required', Rule::in(['parent_guardian','emergency'])], // check each item in the array
            'contacts.*.first_name' => 'required', // check each item in the array
            'contacts.*.last_name' => 'required', // check each item in the array
            'contacts.*.phone_number' => 'required', // check each item in the array
            'contacts.*.email' => 'nullable|email', // check each item in the array
            'contacts.*.relationship' => 'required', // check each item in the array
        ]);
    }

    function validatePassportData(): array
    {
        return $attributes = request()->validate([
            'passport_issue_date' => 'required|date|before:today',
            'passport_expiration_date' => 'required|date|after:tomorrow',
        ]);
    }
}
