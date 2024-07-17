<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function createUser(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
                'password' => 'required',
            ]

        );

        $user = User::create(
            [
                'name' => $fields['name'],
                'email' => $fields['email'],
                'role' => $fields['role'],
                'password' => bcrypt($fields['password']),
            ]
        );

        $response = [
            'user' => $user,
        ];

        return response($response, 201);
    }
}
