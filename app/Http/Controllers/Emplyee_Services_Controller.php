<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;
use Carbon\Carbon;

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


}
