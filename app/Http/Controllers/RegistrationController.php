<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserRegisteredEmail;
use Mail;
use App\Models\User;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $data['registration_date'] = now();
        $user = User::create($data);

        Mail::to($user->email)->send(new UserRegisteredEmail($user));

        return response()->json(['message' => 'User berhasil didaftarkan dan email terkirim.']);
    }
}
