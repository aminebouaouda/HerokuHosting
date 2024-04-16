<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Director_Services_Controller extends Controller
{
    //ADD EMPLOYEE

    public function AddEmployee(Request $request)
    {
        $added_by = $request->added_by;
    
        $director = User::where('id', $added_by)->where('role', 'Derictor')->first(); // Fetch the director user
    
        if ($director) {

            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users',
            ]);

            $companyName = $director->CompanyName; // Access the CompanyName property from the director user

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
                'CompanyName' => $companyName, // Use the retrieved CompanyName
                'telephone' => $request->telephone,
                'email' => $request->email,
                'password' => $request->email,
                'role' => $request->role,
                'isactive' => $request->isactive,
                'profile' => $new_name
            ]);
             return response()->json([
                'message' => 'Employee add successful',
                'user' => $user,
            ], 200);

            } else {
            return response()->json([
                'message' => 'You dont have permission to add this user',
            ], 403);
            }
    }

    //Drop Employee

    public function DropEmployee(Request $request){

        $Derictor_id = $request->Derictor_id;
        $Employee_id = $request->Employee_id;

        $director = User::where('id', $Derictor_id)->where('role', 'Derictor')->first();
        // $employee = User::where('id', $Employee_id)->first();

        if ($director) {
        
            $employee =User::where('id', $Employee_id)->where('role', '!=', 'Derictor')->first();

            if ($employee) {
        
                $employee->delete();
            
                return response()->json(['message' => 'Employee deleted successfully']);

            } else {
                return response()->json(['error' => 'Employee not found'], 404);
            }
    
        }else{
            return response()->json(['error' => 'You dont have permission to delet this user'], 403);
        }
    }

    //Fetch Emplyee

    public function FetchEmployee(Request $request)
    {
        $companyName = $request->companyname;
    
        // Fetch employees where role is not 'Director' (assuming 'RH' is the role for Director)
        $employees = User::where('CompanyName', $companyName)
                        ->whereNotIn('role', ['Derictor'])
                        ->orderByDesc('id')
                        ->get();
    
        return $employees;
    }
    


    //Upload image

    public function uploadimage(Request $request){
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_name = rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/upload/images'), $new_name);
            return response()->json([
                'message' => 'image upload successful',
                'name' => $new_name,
            ], 200);
        } else {
            return response()->json([
                'message' => 'image upload failed',
            ], 403);
        }
    }
    
}
