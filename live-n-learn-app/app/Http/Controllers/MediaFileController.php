<?php

namespace App\Http\Controllers;

use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media_files = MediaFile::latest()->get();

        $data = [
            'media_files' => $media_files
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $this->validateMediaFile();

        if($request->hasFile('media_file')) {
            $file = $request->file('media_file');

            if($file->isValid()) {
                $attributes['file_location'] = Storage::put("media_files", $file);
            }
        }

        $media_file = MediaFile::create($attributes);

        $data = [
            'media_file' => $media_file
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(MediaFile $mediaFile)
    {
        $data = [
            'media_file' => $mediaFile
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaFile $mediaFile)
    {
        $attributes = $this->validateMediaFile($mediaFile);

        // $mediaFile->update([
        //     'title' => $request->input('title')
        // ]);

        $data = [
            'media_file' => $mediaFile,
            'attributes' => $attributes
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaFile $mediaFile)
    {
        $mediaFile->delete();

        $data = [
            'message' => 'Media File destroyed successfully.'
        ];

        return response()->json($data);
    }
    
    function validateMediaFile(?MediaFile $mediaFile = null): array
    {
        $mediaFile ??= new MediaFile();

        return $attributes = request()->validate([
            'title' => 'nullable',
        ]);
    }
}
