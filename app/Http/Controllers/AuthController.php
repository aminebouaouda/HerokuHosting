<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Create a user account
    public function createCompte(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'CompanyName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'CompanyName' => $request->CompanyName,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'Derictor',
            'isactive'=>1
        ]);

        return response()->json([
            'message' => 'SignUp successful',
            'datat' => $user, 
        ]);

        return response()->json([
            'message' => 'Invalid SignUp',
        ], 401);
    }

//Login
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();
    
        return response()->json([
            'message' => 'Login successful',
            'role' => $user->role, 
        ]);
    }

    return response()->json([
        'message' => 'Invalid credentials',
    ], 401);
}


//PROFILE

public function profile(){

    $userData = User::find(10);

        if ($userData) {
            return response()->json([
                'message' => 'Login successful',
                'role' => $user->role,
                'userData' => $userData, // Return user data where ID equals 10
            ]);
        } else {
            return response()->json([
                'message' => 'User data not found for ID 10',
            ], 404);
        }
}


}