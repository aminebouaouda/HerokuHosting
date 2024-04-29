<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;

class VacationController extends Controller
{

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
            $new_name = rand().'.'.$image->getClientOriginalExtension();
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

    public function fetchVacationsDerictore(Request $request)
    {
    $vacations = Vacation::join('users', 'users.id', '=', 'vacations.employee_id')
                    ->where('users.CompanyName', 'GM-Soft')
                    ->get(['vacations.*','users.email','users.firstname','users.lastname']);
                    // ->get(['vacations.*']);
    return response()->json(['vacations' => $vacations], 200);
    }


    //ADD VACATION for Employee

    public function fetchVacationsEmployee(Request $request)
    {
    
        $vacations = Vacation::where('employee_id', $request->employee_id)
                        ->orderByDesc('id')
                        ->get();
    
        return $vacations;
    }


    //DROP VACATION for Employee

    public function deleteVacation(Request $request)
     {
    // Find the vacation by ID
    $vacation = Vacation::find($request->id);

     // Check if vacation exists
    if (!$vacation) {
      return response()->json(['error' => 'Vacation not found'], 404);
    }

    // Delete the vacation
     $vacation->delete();

     return response()->json(['message' => 'Vacation deleted successfully'], 200);
    }




    //UPDATE OF VACATION
    // UPDATE VACATION STATUS for Director
    
    public function updateVacationStatus(Request $request)
    {
        // Validate the request data
        $request->validate([
            'vacation_id' => 'required|exists:vacations,id',
            'status' => 'required|string',
        ]);

        // Get the vacation by ID
        $vacation = Vacation::find($request->vacation_id);

        // Check if vacation exists
        if (!$vacation) {
            return response()->json(['error' => 'Vacation not found'], 404);
        }

        // Check if the user's company name is 'GM-Soft' and user role is 'director'
        $user = $request->user();
        if ($user->CompanyName == 'GM-Soft' && $user->role == 'director') {
            // Update the status of the vacation
            $vacation->status = $request->status;
            $vacation->save();

            return response()->json(['message' => 'Vacation status updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }



}   
