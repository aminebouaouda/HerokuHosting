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

            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'CompanyName' => $companyName, // Use the retrieved CompanyName
                'telephone' => $request->telephone,
                'email' => $request->email,
                'password' => $request->email,
                'role' => $request->role,
                'isactive' => $request->isactive,
            ]);
    
            return $user;
        } else {
            // Return an error response if the director does not exist or has the incorrect role
            return response()->json(['error' => 'You dont have permission to add this user'], 403);
        }
    }

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
}
