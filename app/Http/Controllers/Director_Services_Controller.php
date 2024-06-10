<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\Pointage;
use Illuminate\Support\Facades\DB;


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

            $companyName = $director->CompanyName; 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_name = rand().'.'.$image->getClientOriginalExtension();
            $image->move(storage_path('/public/storage'), $new_name);
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
    
    // getEmployeesNotClockedIn
    public function getEmployeesNotClockedIn(Request $request)
    {
        // Get the current date in the format: year-month-day
        $currentDate = Carbon::now()->toDateString();
         
        $usersNotClockedIn = User::leftJoin('pointages', function($join) {
            $join->on('users.id', '=', 'pointages.id_employee');
        })
        ->whereNull('pointages.id_employee')
        ->orWhereRaw('users.id != pointages.id_employee')
        ->orWhere(function($query) use ($currentDate) {
            $query->whereRaw('DATE(pointages.date_pointage) != ?', [$currentDate])
                  ->orWhereNull('pointages.date_pointage');
        })
        ->where('users.CompanyName', $request->CompanyName)
        // ->whereNotIn('role', ['Director'])
        ->select('users.*')
        ->get();

    //    return $usersNotClockedIn;

       if ($usersNotClockedIn) {
        return response()->json([
            'message' => 'successfully',
            'data' => $usersNotClockedIn
        ], 200);
    } else {
        return response()->json([
            'message' => 'Failed to Find Employee'
        ], 500);
    }
    }


    //Emploiyee how check in

    public function getEmployeesWithTimeEntry(Request $request)
    {
        // Get the current date in the format: year-month-day
        $currentDate = Carbon::now()->toDateString();
    
        $employeesWithTimeEntry = User::join('pointages', function($join) {
                $join->on('users.id', '=', 'pointages.id_employee')
                     ->where('pointages.date_pointage', '=', Carbon::today());
            })
            ->where('users.CompanyName', $request->CompanyName)
            // Exclude users with the role of 'Director'
            ->whereNotIn('users.role', ['Director'])
            ->select('users.*')
            ->distinct()
            ->get();
    
        return $employeesWithTimeEntry;
    }
    

    //Employee Take Breake
    public function getEmploiyeesTakebreak(Request $request)
    {
        // Get the current date in the format: year-month-day
        $currentDate = Carbon::now()->toDateString();
    
        $employeesWithTimeEntry = User::join('pointages', function($join) {
                $join->on('users.id', '=', 'pointages.id_employee')
                     ->where('pointages.date_pointage', '=', Carbon::today());
            })
            ->where('users.CompanyName', $request->CompanyName)
            ->whereNotNull('pointages.pause_exit')
            // Exclude users with the role of 'Director'
            ->whereNotIn('users.role', ['Director'])
            ->select('users.*')
            ->distinct()
            ->get();
    
        return $employeesWithTimeEntry;
    }
    


    //Employee After Breake
    public function getEmploiyeesAfterBreak(Request $request)
    {
        // Get the current date in the format: year-month-day
        $currentDate = Carbon::now()->toDateString();
    
        $employeesWithTimeEntry = User::join('pointages', function($join) {
                $join->on('users.id', '=', 'pointages.id_employee')
                     ->where('pointages.date_pointage', '=', Carbon::today());
            })
            ->where('users.CompanyName', $request->CompanyName)
            ->whereNotNull('pointages.pause_entry')
            // Exclude users with the role of 'Director'
            ->whereNotIn('users.role', ['Director'])
            ->select('users.*')
            ->distinct()
            ->get();
    
        return $employeesWithTimeEntry;
    }

    
    //Employee Leave Work
    public function getEmployeeLeave(Request $request)
    {
        // Get the current date in the format: year-month-day
        $currentDate = Carbon::now()->toDateString();
    
        $employeesWithTimeEntry = User::join('pointages', function($join) {
                $join->on('users.id', '=', 'pointages.id_employee')
                     ->where('pointages.date_pointage', '=', Carbon::today());
            })
            ->where('users.CompanyName', $request->CompanyName)
            ->whereNotNull('pointages.time_exit')
            // Exclude users with the role of 'Director'
            ->whereNotIn('users.role', ['Director'])
            ->select('users.*')
            ->distinct()
            ->get();
    
        return $employeesWithTimeEntry;
    }

    //ADD PROJECTS
    public function AddProject(Request $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_name' => $request->company_name, // Corrected from 'companyName'
        ]);
    
        // Return a JSON response with success message and the created project
        return response()->json([
            'message' => 'Project added successfully',
            'project' => $project,
        ], 200);
    }

       
     public function fetchProjects(Request $request)
{
    // Retrieve projects where company_name is 'gmsoft' from the database
    $projects = Project::where('company_name', $request->company_name)->get();

    // Check if any projects were found
    if ($projects->isEmpty()) {
        return response()->json([
            'message' => 'No projects found for company gmsoft',
            'projects' => [],
        ], 404);
    }

    // Return the projects as a JSON response
    return response()->json([
        'message' => 'Projects fetched successfully',
        'projects' => $projects,
    ], 200);
}





// //PART OF HANDLING THE PROFILES
// public function fetchAuthenticatedUserData(Request $request)
// {
//     try {
//         // Retrieve authenticated user data
//         $user = $request->user();

//         // You can modify this logic to fetch additional data as needed
//         // For example, if you want to fetch additional data from the database,
//         // you can do something like this:
//         // $userData = User::findOrFail($user->id);

//         // Return user data as JSON response
//         return response()->json($user);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Failed to fetch user information'], 500);
//     }
// }

public function fetchAuthenticatedUserData($userId)
{
    try {
        // Find the user(s) by user ID
        $user = User::find($userId);

        if (!$user) {
            // User not found
            return response()->json(['error' => 'User not found'], 404);
        } else {
            // Return the user information
            return response()->json($user);
        }
    } catch (\Exception $e) {
        // Handle any potential errors
        return response()->json(['error' => 'Failed to fetch user information'], 500);
    }
}
    public function getMostActiveEmployees()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $mostActiveEmployees = Pointage::select('id_employee', DB::raw('count(*) as total_pointages'))
            ->whereMonth('date_pointage', $currentMonth)
            ->whereYear('date_pointage', $currentYear)
            ->groupBy('id_employee')
            ->orderBy('total_pointages', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'message' => 'Most active employees retrieved successfully',
            'data' => $mostActiveEmployees
        ], 200);
    }
}


