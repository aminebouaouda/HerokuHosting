<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SentFeuille;
use Illuminate\Support\Facades\DB;

class SentFeuilleController extends Controller
{
    public function store(Request $request)
    {
        $sentFeuille = SentFeuille::create([
            'feuille_name' => $request->feuille_name,
            'user_id' => $request->user_id,
            'total_regular_time' => $request->total_regular_time,
        ]);

        return response()->json($sentFeuille, 201);
    }
    public function checkFeuille(Request $request)
    {
        $userId = $request->query('userId');
        $feuilleName = $request->query('feuilleName');

        $record = DB::table('sent_feuille')
            ->where('user_id', $userId)
            ->where('feuille_name', $feuilleName)
            ->first();

        return response()->json(['exists' => $record ? true : false]);
    }
}
