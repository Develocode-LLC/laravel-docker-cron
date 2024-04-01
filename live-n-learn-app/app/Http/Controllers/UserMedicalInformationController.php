<?php

namespace App\Http\Controllers;

use App\Models\UserMedicalInformation;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserMedicalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $auth_user = Auth::user();

        $is_same_user = ($auth_user->id === $user->id);
        $isnot_same_user_but_traveler = ($auth_user->id !== $user->id && $user->class == 'traveler');

        if(!$is_same_user && $isnot_same_user_but_traveler)
        {
            $error = [
                'message' => 'You do not have access to this information'
            ];
            return response()->json($error, 422);
        }

        $data = [
            'medical_information' => $user->medical_information
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $auth_user = Auth::user();

        $is_same_user = ($auth_user->id === $user->id);
        $isnot_same_user_but_traveler = ($auth_user->id !== $user->id && $user->class == 'traveler');

        if(!$is_same_user && !$isnot_same_user_but_admin)
        {
            $error = [
                'message' => 'You do not have access to this information'
            ];
            return response()->json($error, 422);
        }

        if($user->medical_information)
        {
            $error = [
                'message' => 'This user already has medical information.'
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validateUserMedicalInformation();
        if($attributes['user_diet']) $attributes['diet'] = implode(',', $attributes['user_diet']);

        $userMedicalInformation = $user->medical_information()->create($attributes);

        $data = [
            'medical_information' => $userMedicalInformation
        ];

        return response()->json($data);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, UserMedicalInformation $userMedicalInformation)
    {
        $auth_user = Auth::user();

        $is_same_user = ($auth_user->id === $user->id);
        $isnot_same_user_but_traveler = ($auth_user->id !== $user->id && $user->class == 'traveler');

        if(!$is_same_user && !$isnot_same_user_but_admin)
        {
            $error = [
                'message' => 'You do not have access to this information'
            ];
            return response()->json($error, 422);
        }

        if(!$user->medical_information)
        {
            $error = [
                'message' => 'This user does not have medical information to update.'
            ];
            return response()->json($error, 422);
        }

        if($user->id == $userMedicalInformation->user_id)
        {
            $attributes = $this->validateUserMedicalInformation($userMedicalInformation);
            $attributes['diet'] = ($attributes['user_diet']) ? implode(',', $attributes['user_diet']) : "";
    
            $userMedicalInformation->update($attributes);
    
            $data = [
                'medical_information' => $userMedicalInformation
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'message' => 'Invalid Media File'
            ];
    
            return response()->json($data, 422);
        }
    }

    function validateUserMedicalInformation(?UserMedicalInformation $userMedicalInformation = null): array
    {
        $userMedicalInformation ??= new UserMedicalInformation();

        return $attributes = request()->validate([
            'has_special_accommodations' => 'required|boolean',
            'special_accommodations_details' => 'required_if_accepted:has_special_accommodations',

            'has_preexisting_conditions' => 'required|boolean',
            'preexisting_conditions_details' => 'required_if_accepted:has_preexisting_conditions',
            'preexisting_conditions_warning_sign' => 'required_if_accepted:has_preexisting_conditions',
            
            'has_allergies' => 'required|boolean',
            'allergies_details' => 'required_if_accepted:has_allergies',
            'allergic_reaction_details' => 'required_if_accepted:has_allergies',
            
            'has_dietary_restrictions' => 'required|boolean',
            'dietary_restriction_details' => 'required_if_accepted:has_dietary_restrictions',
            
            'has_prescription_medications' => 'required|boolean',
            'prescription_medications_details' => 'required_if_accepted:has_prescription_medications',
            
            'has_otc_medications' => 'required|boolean',
            'otc_medications_details' => 'required_if_accepted:has_otc_medications',
            
            'has_additional_information' => 'required|boolean',
            'additional_information_details' => 'required_if_accepted:has_additional_information',
            
            'user_diet' => 'nullable|array',
            'diet_details' => Rule::requiredIf(function () {
                return in_array('other', request('user_diet'));
            }),
        ]);
    }
}
