<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;
use Carbon\Carbon;
use App\Models\Tracking;
// use Dotenv\Validator ;
use Illuminate\Support\Facades\Validator;

class Emplyee_Services_Controller extends Controller
{

//ADD POINTAGE
    public function pointage(Request $request)
    {
        $request->validate([
            'id_employee' => 'required'
        ]);
        
        // Get the current date
        $currentDate = Carbon::now()->toDateString();  
        
        // Check if a pointage entry exists for the current date and employee
        $existingPointage = Pointage::where('date_pointage', $currentDate)
                                     ->where('id_employee', $request->id_employee)
                                     ->first();
    
        if ($existingPointage) {
            // Update the existing pointage entry with new values
            $existingPointage->update([
                'time_entry' => $request->time_entry,
                'pause_exit' => $request->pause_exit,
                'pause' => $request->pause,
                'time_exit' => $request->time_exit,
                'extra_hours' => $request->extra_hours,
            ]);
    
            return response()->json([
                'message' => 'Pointage updated successfully',
                'data' => $existingPointage
            ], 200);
        } else {
            // Create a new pointage entry
            $pointage = Pointage::create([
                'time_entry' => $request->time_entry,
                'pause_exit' => $request->pause_exit,
                'pause' => $request->pause,
                'time_exit' => $request->time_exit,
                'extra_hours' => $request->extra_hours,
                'date_pointage' => $currentDate,
                'id_employee' => $request->id_employee
            ]);
    
            if ($pointage) {
                return response()->json([
                    'message' => 'Pointage created successfully',
                    'data' => $pointage
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Failed to create pointage'
                ], 500);
            }
        }
    }
    

    
// Update Pause Exit
public function updatePauseExit(Request $request)
{
    $request->validate([
        'id_employee' => 'required'
    ]);

    // Get the current day, month, and year
    $currentDay = Carbon::now()->day;
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Find the Pointage by employee_id and date_pointage
    $pointage = Pointage::where('id_employee', $request->id_employee)
        ->whereDay('date_pointage', $currentDay)
        ->whereMonth('date_pointage', $currentMonth)
        ->whereYear('date_pointage', $currentYear)
        ->first();

    if (!$pointage) {
        return response()->json([
            'message' => 'Pointage not found for employee on the current date',
            'employee_id' => $employeeId,
            'current_date' => Carbon::now()->toDateString()
        ], 404);
    }

    // Update the Pause Exit
    $pointage->update(['pause_exit' => $request->pause_exit]);

    return response()->json([
        'message' => 'Pause exit updated successfully',
        'data' => $pointage
    ], 200);
}


// Update Pause Entry
public function updatePauseEntry(Request $request)
{
    $request->validate([
        'id_employee' => 'required'
    ]);

    // Get the current day, month, and year
    $currentDay = Carbon::now()->day;
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Find the Pointage by employee_id and date_pointage
    $pointage = Pointage::where('id_employee', $request->id_employee)
        ->whereDay('date_pointage', $currentDay)
        ->whereMonth('date_pointage', $currentMonth)
        ->whereYear('date_pointage', $currentYear)
        ->first();

    if (!$pointage) {
        return response()->json([
            'message' => 'Pointage not found for employee on the current date',
            'employee_id' => $request->id_employee,
            'current_date' => Carbon::now()->toDateString()
        ], 404);
    }

    // Update the Pause Exit
    $pointage->update(['pause_entry' => $request->pause_entry]);

    return response()->json([
        'message' => 'Pause entry updated successfully',
        'data' => $pointage
    ], 200);
}





// Date Sorty
public function TimeExite(Request $request)
{
    $request->validate([
        'id_employee' => 'required'
    ]);

    // Get the current day, month, and year
    $currentDay = Carbon::now()->day;
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Find the Pointage by employee_id and date_pointage
    $pointage = Pointage::where('id_employee', $request->id_employee)
        ->whereDay('date_pointage', $currentDay)
        ->whereMonth('date_pointage', $currentMonth)
        ->whereYear('date_pointage', $currentYear)
        ->first();

    if (!$pointage) {
        return response()->json([
            'message' => 'Pointage not found for employee on the current date',
            'employee_id' => $request->id_employee,
            'current_date' => Carbon::now()->toDateString()
        ], 404);
    }

    // Update the Pause Exit
    $pointage->update(['time_exit' => $request->time_exit]);

    return response()->json([
        'message' => 'Pause entry updated successfully',
        'data' => $pointage
    ], 200);
}




// //time tracking part 2 
// public function startPointage(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'employee_id' => 'required|exists:users,id',
//             'project_id' => 'required|exists:projects,id',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         $tracking = new Tracking();
//         $tracking->employee_id = $request->employee_id;
//         $tracking->project_id = $request->project_id;
//         $tracking->start_time = now();
//         $tracking->status = 'in_progress';
//         $tracking->save();

//         return response()->json(['message' => 'Pointage started successfully'], 201);
//     }

//     // Method to end pointage
//     public function endPointage(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'id' => 'required|exists:pointage',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         $tracking = Tracking::findOrFail($request->id);
//         $tracking->end_time = now();

//         // Calculate total worked hours
//         $start_time = strtotime($tracking->start_time);
//         $end_time = strtotime($tracking->end_time);
//         $total_hours = ($end_time - $start_time) / 3600;
//         $tracking->total_worked_hours = $total_hours;

//         $tracking->status = 'completed';
//         $tracking->save();

//         return response()->json(['message' => 'Pointage ended successfully']);
//     }

//     // Method to start pause
//     public function startPause(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'id' => 'required|exists:pointage',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         $tracking = Tracking::findOrFail($request->id);
//         $tracking->pause_start_time = now();
//         $tracking->status = 'paused';
//         $tracking->save();

//         return response()->json(['message' => 'Pause started successfully']);
//     }

//     // Method to end pause
//     public function endPause(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'id' => 'required|exists:pointage',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         $tracking = Tracking::findOrFail($request->id);
//         $tracking->pause_end_time = now();

//         // Calculate total pause hours
//         $start_time = strtotime($tracking->pause_start_time);
//         $end_time = strtotime($tracking->pause_end_time);
//         $total_hours = ($end_time - $start_time) / 3600;
//         $tracking->total_pause_hours = $total_hours;

//         $tracking->status = 'in_progress';
//         $tracking->save();

//         return response()->json(['message' => 'Pause ended successfully']);
//     }

//     // Method to get all pointage records
//     public function index()
//     {
//         $pointages = Tracking::all();
//         return response()->json($pointages);
//     }

//     // Method to show a specific pointage record
//     public function show($id)
//     {
//         $pointage = Tracking::findOrFail($id);
//         return response()->json($pointage);
//     }

//     // Method to update a specific pointage record
//     public function update(Request $request, $id)
//     {
//         $tracking = Tracking::findOrFail($id);
//         $tracking->update($request->all());
//         return response()->json(['message' => 'Pointage updated successfully']);
//     }

//     // Method to delete a specific pointage record
//     public function destroy($id)
//     {
//         $tracking = Tracking::findOrFail($id);
//         $tracking->delete();
//         return response()->json(['message' => 'Pointage deleted successfully']);
//     }
}
