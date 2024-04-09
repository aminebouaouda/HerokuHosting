<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;

class Emplyee_Services_Controller extends Controller
{
    // Pointage
    public function pointage(Request $request)
    {
        $request->validate([
            // Add your validation rules here
            'date_pointage' => 'required',
            'id_pointeur' => 'required',
            'id_employee' => 'required'
        ]);
        
        $pointage = Pointage::create([
            'morning_entry' => $request->morning_entry,
            'morning_exit' => $request->morning_exit,
            'evening_entry' => $request->evening_entry,
            'evening_exit' => $request->evening_exit,
            'totale_hours' => $request->totale_hours,
            'extra_hours' => $request->extra_hours,
            'date_pointage' => $request->date_pointage,
            'id_pointeur' => $request->id_pointeur,
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
