<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeTracking;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TimeTrackingController extends Controller
{
    public function saveTimeData(Request $request)
    {
        $data = $request->all();

        // Save TimeTracking
        $timeTracking = new TimeTracking();
        $timeTracking->user_id = $data['userId'];
        $timeTracking->feuille_name = $data['feuilleName'];
        $timeTracking->project_name = $data['projectName'];
        $timeTracking->day_of_week = $data['dayOfWeek'];
        $timeTracking->start_time = $data['startTime']; // Assuming startTime is sent as a string
        $timeTracking->end_time = $data['endTime'];     // Assuming endTime is sent as a string
        $timeTracking->total_regular_time = $data['totalRegularTime']; // Assuming totalRegularTime is sent as a string
        $timeTracking->additional_hours = $data['additionalHours']; // Handle null additional hours
        $timeTracking->comment = $data['comment'];     // Assuming comment is sent
        $timeTracking->is_am = $data['isAM'];         // Added is_am field
        $timeTracking->is_am0 = $data['isAM0'];       // Added is_am0 field
        $timeTracking->save();

        // Save tasks associated with the time tracking
        if (isset($data['tasks'])) {
            foreach ($data['tasks'] as $taskData) {
                $task = new Task();
                $task->time_tracking_id = $timeTracking->id;
                $task->task_name = $taskData['taskName'];
                $task->time = $taskData['time'];
                $task->save();
            }
        }

        return response()->json(['message' => 'Data saved successfully'], 200);
    }
    public function getProjects(Request $request)
{
    $userId = $request->query('userId');
    $feuilleName = $request->query('feuilleName');

    // Log incoming parameters
    Log::info('Fetching projects for user ID: ' . $userId . ' and feuille name: ' . $feuilleName);

    // Fetch projects with project IDs
    $projects = TimeTracking::where('user_id', $userId)
                            ->where('feuille_name', $feuilleName)
                            ->select('id', 'project_name', 'total_regular_time', 'day_of_week')
                            ->get();

    // Log fetched projects
    Log::info('Projects found: ' . $projects->toJson());

    return response()->json($projects);
}

public function deleteProject(Request $request)
{
    $projectId = $request->input('projectId');

    // Log incoming parameters
    Log::info('Deleting project with project ID: ' . $projectId);

    // Find the project by ID
    $project = TimeTracking::find($projectId);

    if (!$project) {
        // Project not found
        Log::error('Project not found.');
        return response()->json(['status' => 'error', 'message' => 'Project not found.'], 404);
    }

    // Delete associated tasks
    $deletedTasks = Task::where('time_tracking_id', $projectId)->delete();

    // Delete project
    $deletedProject = $project->delete();

    if ($deletedProject) {
        Log::info('Project deleted successfully.');
        return response()->json(['status' => 'success']);
    } else {
        Log::error('Failed to delete project.');
        return response()->json(['status' => 'error'], 500);
    }
}



    
public function getTotalRegularTime(Request $request)
{
    $userId = $request->query('userId');
    $feuilleName = $request->query('feuilleName');

    // Log incoming parameters
    Log::info('Fetching total regular time for user ID: ' . $userId . ' and feuille name: ' . $feuilleName);

    // Fetch total regular time
    $totalRegularTimes = TimeTracking::where('user_id', $userId)
                                     ->where('feuille_name', $feuilleName)
                                     ->get(['day_of_week', 'total_regular_time as total_time']);

    // Log fetched data
    Log::info('Total Regular Times: ' . $totalRegularTimes->toJson());

    return response()->json($totalRegularTimes);
}
public function TotalRegularTime(Request $request)
{
    $userId = $request->query('userId');
    $feuilleName = $request->query('feuilleName');

    // Fetch total regular time
    $totalRegularTimeInSeconds = TimeTracking::where('user_id', $userId)
                                             ->where('feuille_name', $feuilleName)
                                             ->sum(DB::raw("TIME_TO_SEC(total_regular_time)"));
    
    // Convert total seconds back to HH:MM:SS format
    $hours = floor($totalRegularTimeInSeconds / 3600);
    $minutes = floor(($totalRegularTimeInSeconds % 3600) / 60);
    $seconds = $totalRegularTimeInSeconds % 60;
    $totalRegularTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

    return response()->json(['totalRegularTime' => $totalRegularTime]);
}

}