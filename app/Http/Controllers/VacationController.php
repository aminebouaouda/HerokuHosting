<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VacationController extends Controller
{
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id');
    // }
    //ADD VACATION


    public function AddVacation(Request $request)
    {


        $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string',
            'employee_id' => 'required|exists:users,id',
            'company_name' => 'required|string',
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/upload/images'), $new_name);
            // return response()->json($new_name);
        } else {
            $new_name = null;
        }

        $vacation = Vacation::create([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'file' => $new_name,
            'status' => $request->status,
            'employee_id' => $request->employee_id,
            'company_name' => $request->company_name,
        ]);

        return response()->json([
            'message' => 'vacation add successful',
            'vacation' => $vacation,
        ], 200);
    }

    //ADD VACATION for Derictore

    // public function fetchVacationsDerictore(Request $request)
    // {
    //     $vacations = Vacation::join('users', 'users.id', '=', 'vacations.employee_id')
    //         ->where('users.CompanyName', 'GM-Soft')
    //         ->get(['vacations.*', 'users.email', 'users.firstname', 'users.lastname']);
    //     // ->get(['vacations.*']);
    //     return response()->json(['vacations' => $vacations], 200);
    // }


    //ADD VACATION for Employee

    public function employeeVacations(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'employee_id' => 'required|exists:users,id',
        ]);
    
        // Fetch the vacations for the employee
        $vacations = Vacation::where('employee_id', $request->employee_id)
            ->orderByDesc('id')
            ->get();
    
        // Return a JSON response
        return response()->json(['vacations' => $vacations], 200);
    }
    


    //DROP VACATION for Employee
    public function deleteVacation(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|exists:vacations,id',
        ]);
    
        // Find the vacation by ID or fail if not found
        $vacation = Vacation::findOrFail($request->id);
    
        // Delete the vacation
        $vacation->delete();
    
        return response()->json(['message' => 'Vacation deleted successfully'], 200);
    }
    
    //UPDATE OF VACATION

    public function updateVacation(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'type' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'string',
            'employee_id' => 'exists:users,id',
            'company_name' => 'string',
        ]);
    
        // Find the vacation by ID or fail if not found
        $vacation = Vacation::findOrFail($id);
    
        // Update the vacation
        $vacation->update($request->all());
    
        return response()->json(['message' => 'Vacation updated successfully', 'vacation' => $vacation], 200);
    }
    
    //vacations PART DIRECTOR
//this method used to approve or rejct or keep en attente the emplyoe vacation dmend
public function approveOrRejectVacation(Request $request)
{
    $vacationId = $request->input('id'); // Correct input name
    $action = $request->input('status');

    // Find the vacation by ID
    $vacation = Vacation::find($vacationId);

    if (!$vacation) {
        return response()->json(['error' => 'Vacation not found'], 404);
    }

    // Update vacation status based on action
    if ($action === 'approved' || $action === 'rejected') {
        $vacation->status = $action;
        $vacation->save();

        return response()->json(['message' => 'Vacation request ' . $action . ' successfully']);
    } else {
        return response()->json(['error' => 'Invalid action'], 400);
    }
}


//metod for fetching emplyoer vacations
public function fetchEmployeeVacations(Request $request)
{
    // Fetch all vacations from the vacations table
    $vacations = Vacation::all();

    return response()->json($vacations);
}


//fetching the user by it Id
//i didn'T implemnt this functionnality yet 
public function fetchUserByEmployeeId($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }


// public function fetchUserByEmployeeId($employeeId)
//     {
//         try {
//             // Fetch the user from the database based on the employee ID
//             $user = User::where('employee_id', $employeeId)->first();

//             if ($user) {
//                 // Return the user data
//                 return response()->json($user);
//             } else {
//                 // User not found
//                 return response()->json(['error' => 'User not found'], 404);
//             }
//         } catch (\Exception $e) {
//             // Handle any errors that occur
//             return response()->json(['error' => 'Failed to fetch user information'], 500);
//         }
//     }
    // public function fetchUserByEmployeeId($employeeId)
    // {
    //     // Find the employee with the given ID
    //     $employee = User::find($employeeId);

    //     // Check if the employee exists
    //     if (!$employee) {
    //         return response()->json(['error' => 'Employee not found'], 404);
    //     }

    //     // Retrieve the user associated with the employee
    //     $user = $employee->user;

    //     // Check if a user is associated with the employee
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found for this employee'], 404);
    //     }

    //     // Return the user data
    //     return response()->json($user);
    // }
}
