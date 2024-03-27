<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth_user = Auth::user();

        $messages = Message::where('author_id', $auth_user->id)
                            ->orWhere(function ($query) {
                                $auth_user = Auth::user();
                                $query->where('recipient_id', $auth_user->id)
                                      ->where('sent', 1);
                            })
                            ->latest()
                            ->get();

        $data = [
            'user_messages' => $messages
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth_user = Auth::user();

        $attributes = $this->validateMessage();
        $attributes['author_id'] = $auth_user->id;

        $message = Message::create($attributes);

        $data = [
            'user_message' => $message
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        $auth_user = Auth::user();

        if($message->recipient_id == $auth_user->id || $message->author_id == $auth_user->id)
        {
            $data = [
                'user_message' => $message
            ];
    
            return response()->json($data);
        }
        else
        {
            $error = [
                'message' => 'User does not have access to this message'
            ];

            return response()->json($error, 422);
        }
    }

    function validateMessage(?Message $message = null): array
    {
        $message ??= new Message();

        return $attributes = request()->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required',
            'message' => 'required',
            'message_send_date' => 'required|date|after:yesterday',
        ]);
    }
}
