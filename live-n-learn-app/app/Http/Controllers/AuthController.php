<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationKey;
use DateTimeImmutable;

class AuthController extends Controller
{
    
    /**
     * Handle an incoming authentication request via API.
     */
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $user = $request->user();

        $token = $user->createToken(
            $user->email, ['*'], now()->addDay()
        );

        $data = [
            'user' => $user,
            'token' => $token->plainTextToken,
            'exiration' => $token->accessToken->expires_at->toDateTimeString()
        ];

        return response()->json($data);
    }

    /**
     * Handle an incoming registration request via API.
     */
    public function register(Request $request)
    {
        $request->validate([
            'class' => ['required', Rule::in(['administrator', 'host_family', 'local_coordinator', 'traveler'])],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'class' => $request->class,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken(
            $user->email, ['*'], now()->addDay()
        );

        $data = [
            'user' => $user,
            'token' => $token->plainTextToken,
            'exiration' => $token->accessToken->expires_at->toDateTimeString()
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function resend_registration(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // Send Registration email if they haven't registered
        if (!$user->has_registered)
        {
            if (!$user->registration_key)
            {
                $this->generate_registration_key($user);
            }

            Mail::to($user)->send(new UserRegistrationKey($user));
        }

        $data = [
            'user' => $user
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function enter_registration_key(Request $request)
    {
        $user = User::where('email', $request->email)
                        ->where('registration_key', $request->registration_key)->first();

        if(!$user || $user->has_registered)
        {
            $error = [
                'status' => false,
                'message' => 'Invalid Registration Information'
            ];
    
            return response()->json($error, 422);
        }

        $token = $this->generate_reset_password_token($user);

        // $user->update([
        //     'has_registered' => 1
        // ]);

        $data = [
            'user' => $user,
            'reset_token' => $token
        ];

        return response()->json($data);
    }

    private function generate_reset_password_token(User $user)
    {
        $token = Str::password(32, true, true, false, false);
        $token_bcrypt = bcrypt($token);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token_bcrypt,
            'created_at' => new DateTimeImmutable()
        ]);

        return $token;
    }

    /**
     * Handle an incoming authentication request via API.
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        $data = [
            'message' => "Logout successful."
        ];

        return response()->json($data);
    }

}