<?php

namespace App\Http\Controllers;

use App\Models\TripFormSignature;
use App\Models\Trip;
use App\Models\User;
use App\Models\Form;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class TripFormSignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Trip $trip, Form $form, User $user)
    {
        $form_signatures = TripFormSignature::where('form_id', $form->id)
                        ->where('trip_id', $trip->id)
                        ->where('user_id', $user->id)
                        ->get();

        $data = [
            'success' => 1,
            'form_signatures' => $form_signatures
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Trip $trip, Form $form, User $user)
    {
        $attributes = $this->validateSignature();
        $form_id = $form->id;
        $trip_id = $trip->id;
        $user_id = $user->id;

        $file = $this->convertBase64ToImage($attributes['signature']);

        $file_path = Storage::put("user/$user_id/trip/$trip_id/signature", $file);

        $attributes['signature_file_location'] = $file_path;
        $attributes['form_id'] = $form_id;
        $attributes['trip_id'] = $trip_id;
        $attributes['user_id'] = $user_id;
        
        $TripFormSignature = TripFormSignature::create($attributes);

        $data = [
            'success' => 1,
            'file_signature' => $TripFormSignature
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Trip $trip, TripFormSignature $TripFormSignature)
    {
        $form_id = $form->id;
        $trip_id = $trip->id;
        $user_id = $user->id;
        
        // Check that the trip image belong to the trip
        if($trip_id === $TripFormSignature->trip_id && 
            $user_id === $TripFormSignature->user_id && 
            $form_id === $TripFormSignature->form_id)
        {
            Storage::delete($TripFormSignature->signature_file_location);
            $TripFormSignature->delete();

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
            'signature_type' => 'required',
            'name' => 'required',
            'signature' => 'required',
            'signature_date' => 'required|date',
        ]);
    }
}
