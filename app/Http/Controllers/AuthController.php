<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request -> validate([
            'name_input' => 'required',
            'email_input' => 'required|email',
            'password_input' => 'required|min:6'
        ]);

        $response = [
            'name' => $request->name_input,
            'email' => $request->email_input,
        ];

        return response() -> json($response);
    }
}