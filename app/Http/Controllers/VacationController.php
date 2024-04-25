<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;

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
}
