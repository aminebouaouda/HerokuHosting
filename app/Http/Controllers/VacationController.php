<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    public function AddVacation(Request $request)
    {
        

        $request->validate([
            'title' => 'required',
            'remark' => 'required',
            'id_employee' => 'required'
        ]);
        
        $vacation = Vacation::create([
            'title' => $request->title,
            'remark' => $request->remark,
            'file' => $request->file('file')->store('uploads'), // Assuming 'file' is the name of your file input field
            'is_accept' => 0,
            'date_demande' => $request->date_demande,
            'id_employee' => $request->id_employee
        ]);
        
        if ($vacation) {
            return response()->json([
                'message' => 'successfully',
                'data' => $vacation
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed'
            ], 500);
        }
    }

    // public function UpdateVacation(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'remark' => 'required',
    //         'id_employee' => 'required'
    //     ]);
        
    //     $vacation = Vacation::find($id);
    //     if (!$vacation) {
    //         return response()->json([
    //             'message' => 'Vacation not found'
    //         ], 404);
    //     }

    //     $vacation->title = $request->title;
    //     $vacation->remark = $request->remark;
    //     // Update other fields as needed

    //     if ($vacation->save()) {
    //         return response()->json([
    //             'message' => 'Vacation updated successfully',
    //             'data' => $vacation
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'Failed to update vacation'
    //         ], 500);
    //     }
    // }

    // public function DeleteVacation($id)
    // {
    //     $vacation = Vacation::find($id);
    //     if (!$vacation) {
    //         return response()->json([
    //             'message' => 'Vacation not found'
    //         ], 404);
    //     }

    //     if ($vacation->delete()) {
    //         return response()->json([
    //             'message' => 'Vacation deleted successfully'
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'Failed to delete vacation'
    //         ], 500);
    //     }
    // }

    // public function FetchVacations()
    // {
    //     $vacations = Vacation::all();
    //     return response()->json([
    //         'message' => 'Vacations fetched successfully',
    //         'data' => $vacations
    //     ], 200);
    // }
}
