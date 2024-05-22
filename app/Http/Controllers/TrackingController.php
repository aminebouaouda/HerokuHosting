<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;

class TrackingController extends Controller
{
    public function startTracking(Request $request)
    {
        // Assuming you have the necessary logic to start tracking
        // For example:
        $tracking = new Tracking();
        $tracking->status = 'tracking';
        $tracking->save();

        return response()->json(['message' => 'Tracking started successfully', 'data' => $tracking], 200);
    }

    public function pauseTracking(Request $request, $trackingId)
    {
        // Find the tracking record
        $tracking = Tracking::findOrFail($trackingId);

        // Assuming you have the necessary logic to pause tracking
        // For example:
        $tracking->status = 'paused';
        $tracking->save();

        return response()->json(['message' => 'Tracking paused successfully', 'data' => $tracking], 200);
    }

    public function resumeTracking(Request $request, $trackingId)
    {
        // Find the tracking record
        $tracking = Tracking::findOrFail($trackingId);

        // Assuming you have the necessary logic to resume tracking
        // For example:
        $tracking->status = 'tracking';
        $tracking->save();

        return response()->json(['message' => 'Tracking resumed successfully', 'data' => $tracking], 200);
    }

    public function stopTracking(Request $request, $trackingId)
    {
        // Find the tracking record
        $tracking = Tracking::findOrFail($trackingId);

        // Assuming you have the necessary logic to stop tracking
        // For example:
        $tracking->status = 'finish tracking';
        $tracking->save();

        return response()->json(['message' => 'Tracking stopped successfully', 'data' => $tracking], 200);
    }

    public function updateTrackingRemarks(Request $request, $trackingId)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'remarks' => 'required|string',
            // Add more validation rules as needed
        ]);

        // Find the tracking record
        $tracking = Tracking::findOrFail($trackingId);

        // Update the remarks field
        $tracking->update(['remarks' => $validatedData['remarks']]);

        // Update the status to 'finish tracking'
        $tracking->update(['status' => 'finish tracking']);

        // Return a success response
        return response()->json(['message' => 'Tracking remarks updated successfully', 'data' => $tracking], 200);
    }

    public function startPause(Request $request, $trackingId)
    {
        // Find the tracking record
        $tracking = Tracking::findOrFail($trackingId);

        // Assuming you have the necessary logic to start pause
        // For example:
        $tracking->status = 'pause';
        $tracking->save();

        return response()->json(['message' => 'Tracking paused successfully', 'data' => $tracking], 200);
    }

    public function endPause(Request $request, $trackingId)
    {
        // Find the tracking record
        $tracking = Tracking::findOrFail($trackingId);

        // Assuming you have the necessary logic to end pause
        // For example:
        $tracking->status = 'tracking';
        $tracking->save();

        return response()->json(['message' => 'Pause ended successfully', 'data' => $tracking], 200);
    }
}
