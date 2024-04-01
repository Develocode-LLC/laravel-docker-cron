<?php

namespace App\Http\Controllers;

use App\Models\UserMediaFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserMediaFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $data = [
            'media_files' => $user->media_files
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
        $isnot_same_user_but_admin = ($auth_user->id !== $user->id && $auth_user->class == 'administrator');

        if(!$is_same_user && !$isnot_same_user_but_admin)
        {
            $error = [
                'message' => 'Media File could not be added'
            ];
            return response()->json($error, 422);
        }

        $attributes = $this->validateMediaFile();
        
        if($request->hasFile('media_file')) {
            $media_file = $request->file('media_file');

            if($media_file->isValid()) {
                $file_path = Storage::put("user/{$user->id}/files", $media_file);

                $attributes['file_location'] = $file_path;
            }
        }
        
        $user_media_file = $user->media_files()->create($attributes);

        $data = [
            'media_file' => $user_media_file
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, UserMediaFile $userMediaFile)
    {
        // Check that user and user media file match
        if($user->id == $userMediaFile->user_id)
        {
            $data = [
                'media_file' => $userMediaFile
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserMediaFile $userMediaFile)
    {
        // Check that user and user media file match
        if($user->id === $userMediaFile->user_id)
        {
            Storage::delete($userMediaFile->file_location);
            
            $userMediaFile->delete();

            $data = [
                'message' => 'Media File destroyed successfully.'
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

    function validateMediaFile(): array
    {
        return $attributes = request()->validate([
            'title' => 'required',
        ]);
    }
}
