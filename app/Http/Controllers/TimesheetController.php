<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\TasksPause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log facade for logging

class TimesheetController extends Controller
{
    public function sentTimesheet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'date' => 'required|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'addhours' => 'nullable|integer',
                'comment' => 'nullable|string',
                'tasks_pauses' => 'required|array',
                'tasks_pauses.*.start_time' => 'required|date_format:H:i',
                'tasks_pauses.*.end_time' => 'required|date_format:H:i',
                'tasks_pauses.*.type' => 'required|string|max:20',
                'tasks_pauses.*.note' => 'nullable|string',
                'tasks_pauses.*.project_name' => 'nullable|string',
            ]);

            $timesheet = Timesheet::create(array_merge($validatedData, ['sent' => true]));

            foreach ($validatedData['tasks_pauses'] as $taskPauseData) {
                TasksPause::create(array_merge($taskPauseData, ['timesheet_id' => $timesheet->id]));
            }

            Log::info('Timesheet saved successfully');

            return response()->json(['message' => 'Timesheet saved successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error saving timesheet: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to save timesheet'], 500);
        }
    }

    public function saveTimesheet(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'date' => 'required|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'addhours' => 'nullable|integer',
                'comment' => 'nullable|string',
                'tasks_pauses' => 'required|array',
                'tasks_pauses.*.start_time' => 'required|date_format:H:i',
                'tasks_pauses.*.end_time' => 'required|date_format:H:i',
                'tasks_pauses.*.type' => 'required|string|max:20',
                'tasks_pauses.*.note' => 'nullable|string',
                'tasks_pauses.*.project_name' => 'nullable|string',
            ]);

            $timesheet = Timesheet::create($validatedData);

            foreach ($validatedData['tasks_pauses'] as $taskPauseData) {
                TasksPause::create(array_merge($taskPauseData, ['timesheet_id' => $timesheet->id]));
            }

            Log::info('Timesheet saved successfully');

            return response()->json(['message' => 'Timesheet saved successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error saving timesheet: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to save timesheet'], 500);
        }
    }
    public function checkTimesheetStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'date' => 'required|date',
            ]);

            $timesheet = Timesheet::where('user_id', $validatedData['user_id'])
                ->where('date', $validatedData['date'])
                ->where('sent', true)
                ->exists();

            return response()->json(['timesheet_sent' => $timesheet], 200);
        } catch (\Exception $e) {
            Log::error('Error checking timesheet status: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to check timesheet status'], 500);
        }
    }
    public function fetchTimesheetDetail(Request $request)
{
    try {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $timesheet = Timesheet::where('user_id', $validatedData['user_id'])
            ->where('date', $validatedData['date'])
            ->with('tasksPauses')  // Ensure the relationship name is correct
            ->first();

        if (!$timesheet) {
            return response()->json(['error' => 'Timesheet not found'], 404);
        }

        // Convert tasks_pauses to the expected format
        $timesheetArray = $timesheet->toArray();
        $timesheetArray['tasks_pauses'] = $timesheetArray['tasks_pauses'] ?? [];
        foreach ($timesheetArray['tasks_pauses'] as &$taskPause) {
            $taskPause['start_time'] = (string) $taskPause['start_time'];
            $taskPause['end_time'] = (string) $taskPause['end_time'];
        }

        return response()->json(['timesheet' => $timesheetArray], 200);
    } catch (\Exception $e) {
        Log::error('Error fetching timesheet detail: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch timesheet detail'], 500);
    }
}

}