<?php

namespace App\Http\Controllers;

use App\Models\FormSignature;
use App\Models\Trip;
use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class FormSignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user, Trip $trip)
    {
        $form_signatures = FormSignature::where('user_id', $user->id)
                        ->where('trip_id', $trip->id)->get();

        $data = [
            'success' => 1,
            'form_signatures' => $form_signatures
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user, Trip $trip)
    {
        $attributes = $this->validateSignature();
        $user_id = $user->id;
        $trip_id = $trip->id;

        $file = $this->convertBase64ToImage($attributes['signature']);

        $file_path = Storage::put("user/$user_id/trip/$trip_id/signature", $file);

        $attributes['signature_file_location'] = $file_path;
        $attributes['user_id'] = $user_id;
        $attributes['trip_id'] = $trip_id;
        
        $formSignature = FormSignature::create($attributes);

        $data = [
            'success' => 1,
            'file_signature' => $formSignature
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Trip $trip, FormSignature $formSignature)
    {
        // Check that the trip image belong to the trip
        if($trip->id === $formSignature->trip_id && $user->id === $formSignature->user_id)
        {
            $data = [
                'success' => 1,
                'file_signature' => $formSignature
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'success' => 0,
                'message' => 'Trip Signature Not Found'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, Trip $trip, FormSignature $formSignature)
    {
        // Check that the trip image belong to the trip
        if($trip->id === $formSignature->trip_id && $user->id === $formSignature->user_id)
        {
            $attributes = $this->validateSignature();
            $user_id = $user->id;
            $trip_id = $trip->id;
    
            $file = $this->convertBase64ToImage($attributes['signature']);

            Storage::delete($formSignature->signature_file_location);

            $file_path = Storage::put("user/$user_id/trip/$trip_id/signature", $file);
            $attributes['signature_file_location'] = $file_path;

            $formSignature->update($attributes);
    
            $data = [
                'success' => 1,
                'file_signature' => $formSignature
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'success' => 0,
                'message' => 'Trip Signature Not Found'
            ];
    
            return response()->json($data, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Trip $trip, FormSignature $formSignature)
    {
        // Check that the trip image belong to the trip
        if($trip->id === $formSignature->trip_id && $user->id === $formSignature->user_id)
        {
            Storage::delete($formSignature->signature_file_location);
            $formSignature->delete();

            $data = [
                'success' => 1,
                'message' => 'Signature deleted'
            ];
    
            return response()->json($data);
        }
        else
        {
            $data = [
                'success' => 0,
                'message' => 'Trip Signature Not Found'
            ];
    
            return response()->json($data, 422);
        }
    }

    function convertBase64ToImage(string $base64_string)
    {
        // decode the base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );

        return $file;
    }

    function validateSignature(): array
    {
        return $attributes = request()->validate([
            'form_type' => 'required',
            'signature_type' => 'required',
            'name' => 'required',
            'signature' => 'required',
            'signature_date' => 'required|date',
        ]);
    }
}
