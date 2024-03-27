<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\InboundProgram;
use App\Models\User;

class InboundProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inbound_programs = InboundProgram::latest()->get();

        $data = [
            'inbound_programs' => $inbound_programs
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validateInboundProgram();
        $inbound_program = InboundProgram::create($attributes);

        $data = [
            'inbound_program' => $inbound_program
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(InboundProgram $inboundProgram)
    {
        $data = [
            'inbound_program' => $inboundProgram
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InboundProgram $inboundProgram)
    {
        $attributes = $this->validateInboundProgram($inboundProgram);
        $inboundProgram->update($attributes);

        $inboundProgram->refresh();

        $data = [
            'inbound_program' => $inboundProgram
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InboundProgram $inboundProgram)
    {
        $auth_user = Auth::user();

        if($auth_user->class <> 'administrator')
        {
            $error = [
                'message' => 'User does not have access to delete from inbound_programs'
            ];
            return response()->json($error, 422);
        }

        $inboundProgram->update([
            'code' => null,
            'deleted_by_id' => $auth_user->id
        ]);

        $inboundProgram->delete();

        $data = [
            'message' => 'Inbound Program destroyed successfully.'
        ];

        return response()->json($data);
    }

    /**
     * Add User to Inbound Program
     */
    public function add_user(InboundProgram $inboundProgram, User $user)
    {
        $hasUser = $inboundProgram->users()->where('user_id', $user->id)->exists();

        if ($hasUser)
        {
            return response()->json(['message' => 'User already exists in Inbound Program'], 422);
        }

        $inboundProgram->users()->attach($user);

        $data = [
            'message' => 'User added to Inbound Program',
            'user' => $user,
        ];

        return response()->json($data);
    }

    /**
     * Remove User from Inbound Program
     */
    public function remove_user(InboundProgram $inboundProgram, User $user)
    {
        $hasUser = $inboundProgram->users()->where('user_id', $user->id)->exists();

        if (!$hasUser)
        {
            return response()->json(['message' => 'User does not exists in Inbound Program'], 422);
        }

        $inboundProgram->users()->detach($user);

        $data = [
            'message' => 'User removed from Inbound Program',
            'user' => $user,
        ];

        return response()->json($data);
    }

    /**
     * Look Up a Trip by the assigned code
     */
    public function code_lookup(InboundProgram $inboundProgram)
    {
        $data = [
            'inbound_program' => $inboundProgram
        ];

        return response()->json($data);
    }

    /**
     * Create random string
     */
    public function _random_characters(int $length)
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
     * Generate the program code
     */
    public function generate_code(InboundProgram $inboundProgram)
    {
        $program_code = '';
        $inbound_program_count = 0;

        if($inboundProgram->code)
        {
            return response()->json(['message' => "Inbound Program is already active"], 422);
        }

        do {
            $program_code = $this->_random_characters(5);

            $inbound_program_count = InboundProgram::where('code', '=', $program_code)->count();

        } while($inbound_program_count > 0 );

        $inboundProgram->update([
            'code' => $program_code
        ]);

        $data = [
            'inbound_program' => $inboundProgram
        ];

        return response()->json($data);
    }

    function validateInboundProgram(?InboundProgram $inboundProgram = null): array
    {
        $inboundProgram ??= new InboundProgram();

        return $attributes = request()->validate([
            'location_id' => 'nullable|exists:locations,id',
            'partner_id' => 'nullable|exists:partners,id',
            'origin_country' => 'required',
            'national_language' => 'required',
            'available_seats' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    }
}
