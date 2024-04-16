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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_name = rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/upload/images'), $new_name);
            // return response()->json($new_name);
        } else {
            $new_name = '123.jpg';
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'CompanyName' => $request->CompanyName,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'Derictor',
            'isactive'=>1,
            'profile'=>$new_name
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
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json([
            'message' => 'Login successful',
            'role' => $user->role, // Assuming you have a 'role' field in your User model
            'token' => $user->createToken('MyAppToken')->plainTextToken,
        ], 200);
    }

    return response()->json([
        'message' => 'Invalid credentials',
    ], 401);
}


//PROFILE

public function profile(Request $request){

    $userData = User::find($request->user_id);

        if ($userData) {
            return response()->json([
                'message' => 'successful',
                'userData' => $userData, // Return user data where ID equals 10
            ]);
        } else {
            return response()->json([
                'message' => 'User data not found',
            ], 404);
        }
}


}