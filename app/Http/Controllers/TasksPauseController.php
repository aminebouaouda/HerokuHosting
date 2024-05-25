<?php

namespace App\Http\Controllers;

use App\Models\TasksPause;
use Illuminate\Http\Request;

class TasksPauseController extends Controller
{
    public function store(Request $request)
    {
        $tasksPause = TasksPause::create($request->all());
        return response()->json($tasksPause, 201);
    }

    public function update(Request $request, $id)
    {
        $tasksPause = TasksPause::findOrFail($id);
        $tasksPause->update($request->all());
        return response()->json($tasksPause, 200);
    }

    public function destroy($id)
    {
        TasksPause::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}