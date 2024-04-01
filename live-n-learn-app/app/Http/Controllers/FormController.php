<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::latest()->get();

        $data = [
            'forms' => $forms
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $data = [
            'form' => $form
        ];

        return response()->json($data);
    }
}
