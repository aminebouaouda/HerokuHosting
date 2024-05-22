<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\emailMailable; // Assuming you have a Mailable class for sending verification codes
use Illuminate\Support\Str;



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
    
        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            // $image = $request->file('image');
            // $new_name = rand().'.'.$image->getClientOriginalExtension();
             $new_name = '123.jpg';
            $image->move(public_path('/upload/images'), $new_name);
        } else {
            // If no image is uploaded, assign a default image name
            $new_name = '123.jpg';
        }
    
        // Create the user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'CompanyName' => $request->CompanyName,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'Derictor', // Is this intended to be 'Director'?
            'isactive' => 1,
            'profile' => $new_name
        ]);
    
        // Check if user creation was successful
        if ($user) {
            // Return success response with user data
            return response()->json([
                'message' => 'SignUp successful',
                'data' => $user
            ], 200);
        } else {
            // Return error response
            return response()->json([
                'message' => 'Invalid SignUp'
            ], 401);
        }
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
            'id' => $user->id, // Assuming you have a 'id' field in your User model
            'companyName' => $user->CompanyName, // Assuming you have a 'id' field in your User model
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

//Check Email
public function checkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        return response()->json([
            'message' => 'Email found',
            'user' => $user, // Optional: You can return the user data if needed
        ], 200);
    }

    return response()->json([
        'message' => 'Email not found',
    ], 404);
}

//Check CompanyName
public function checkCompanyName(Request $request)
{
    $request->validate([
        'CompanyName' => 'required|string', // Ensure 'CompanyName' is provided and is a string
    ]);

    $user = User::where('CompanyName', $request->CompanyName)->first();

    if ($user) {
        return response()->json([
            'message' => 'CompanyName found',
            'user' => $user, // Optional: You can return the user data if needed
        ], 200);
    }

    return response()->json([
        'message' => 'CompanyName not found',
    ], 404);
}

// Change password by user ID
public function changePassword(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id',
        'password' => 'required|min:6',
    ]);

    $user = User::find($request->id);

    // Update the password
    $user->password = bcrypt($request->password);
    $user->save();

    return response()->json([
        'message' => 'Password changed successfully',
    ], 200);
}

public function sendVerificationCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Generate a verification code
    $verificationCode = Str::random(6);

    // Send the verification code via email
    Mail::to($request->email)->send(new emailMailable($verificationCode));

    // Optionally, you can check if the email was sent successfully
    if (Mail::failures()) {
        return response()->json(['message' => 'Failed to send verification code'], 500);
    }

    return response()->json(['message' => 'Verification code sent successfully'], 200);
}

}