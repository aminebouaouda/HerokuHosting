<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TrackingController extends Controller
{
    // Method to start tracking
    public function startTracking(Request $request)
    {
        Log::info('Received startTracking request', $request->all());

        $request->validate([
            'employee_id' => 'required|integer',
            'project_id' => 'required|integer',
            'status' => 'required|string',
            'task_description' => 'nullable|string',
            'location' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        try {
            $tracking = new Tracking();
            $tracking->employee_id = $request->employee_id;
            $tracking->project_id = $request->project_id;
            $tracking->status = $request->status;
            $tracking->task_description = $request->task_description;
            $tracking->start_time = now();
            $tracking->location = $request->location;
            $tracking->remarks = $request->remarks;
            $tracking->save();

            return response()->json(['message' => 'Tracking started successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error starting tracking: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error starting tracking', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to pause tracking
    public function pauseTracking($trackingId)
    {
        Log::info('Received pauseTracking request', ['trackingId' => $trackingId]);

        try {
            $tracking = Tracking::find($trackingId);
            if (!$tracking) {
                return response()->json(['message' => 'Tracking not found'], 404);
            }

            $tracking->pause_start_time = now();
            $tracking->status = 'Paused';
            $tracking->save();

            return response()->json(['message' => 'Tracking paused successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error pausing tracking: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error pausing tracking', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to resume tracking
    public function resumeTracking($trackingId)
    {
        Log::info('Received resumeTracking request', ['trackingId' => $trackingId]);

        try {
            $tracking = Tracking::find($trackingId);
            if (!$tracking) {
                return response()->json(['message' => 'Tracking not found'], 404);
            }

            $pauseDuration = now()->diffInSeconds($tracking->pause_start_time);
            $tracking->total_pause_hours = $tracking->total_pause_hours + ($pauseDuration / 3600);
            $tracking->pause_start_time = null;
            $tracking->status = 'Tracking';
            $tracking->save();

            return response()->json(['message' => 'Tracking resumed successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error resuming tracking: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error resuming tracking', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to stop tracking
    public function stopTracking(Request $request, $trackingId)
    {
        Log::info('Received stopTracking request', array_merge($request->all(), ['trackingId' => $trackingId]));

        $request->validate([
            'end_time' => 'required|date',
            'total_pause_hours' => 'required|numeric',
        ]);

        try {
            $tracking = Tracking::find($trackingId);
            if (!$tracking) {
                return response()->json(['message' => 'Tracking not found'], 404);
            }

            $tracking->end_time = Carbon::parse($request->end_time);
            $totalWorkedDuration = $tracking->end_time->diffInSeconds($tracking->start_time) - ($request->total_pause_hours * 3600);
            $tracking->total_worked_hours = $totalWorkedDuration / 3600;
            $tracking->status = 'Finished';
            $tracking->save();

            return response()->json(['message' => 'Tracking stopped successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error stopping tracking: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error stopping tracking', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to update tracking remarks
    public function updateTrackingRemarks(Request $request, $trackingId)
    {
        Log::info('Received updateTrackingRemarks request', array_merge($request->all(), ['trackingId' => $trackingId]));

        $request->validate([
            'remarks' => 'required|string',
        ]);

        try {
            $tracking = Tracking::find($trackingId);
            if (!$tracking) {
                return response()->json(['message' => 'Tracking not found'], 404);
            }

            $tracking->remarks = $request->remarks;
            $tracking->save();

            return response()->json(['message' => 'Remarks updated successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error updating remarks: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error updating remarks', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to update tracking status
    public function updateTrackingStatus(Request $request, $trackingId)
    {
        Log::info('Received updateTrackingStatus request', array_merge($request->all(), ['trackingId' => $trackingId]));

        $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $tracking = Tracking::find($trackingId);
            if (!$tracking) {
                return response()->json(['message' => 'Tracking not found'], 404);
            }

            $tracking->status = $request->status;
            $tracking->save();

            return response()->json(['message' => 'Status updated successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error updating status: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error updating status', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to fetch projects
    public function fetchProjects(Request $request)
    {
        Log::info('Received fetchProjects request', $request->all());

        $request->validate([
            'company_name' => 'required|string',
        ]);

        try {
            $projects = Project::where('company_name', $request->company_name)->get();
            return response()->json(['projects' => $projects], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching projects: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error fetching projects', 'error' => $e->getMessage()], 500);
        }
    }

    // Method to complete tracking
    public function completeTracking($trackingId)
    {
        Log::info('Received completeTracking request', ['trackingId' => $trackingId]);

        try {
            $tracking = Tracking::find($trackingId);
            if (!$tracking) {
                return response()->json(['message' => 'Tracking not found'], 404);
            }

            $tracking->status = 'Completed';
            $tracking->save();

            return response()->json(['message' => 'Tracking completed successfully', 'tracking' => $tracking], 200);
        } catch (\Exception $e) {
            Log::error('Error completing tracking: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error completing tracking', 'error' => $e->getMessage()], 500);
        }
    }
}
