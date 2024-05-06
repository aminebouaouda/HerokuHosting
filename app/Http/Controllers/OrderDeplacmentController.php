<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDeplacment; // Ensure you import the OrderDeplacment model here

class OrderDeplacmentController extends Controller
{
    /**
     * Store a newly created OrderDeplacment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AddDeplacement(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'localiastion' => 'required',
            'titel' => 'required',
            'buteDeplacment' => 'required',
            'id_employee' => 'required',
        ]);

        // Create a new OrderDeplacment instance with the request data
        $orderDeplacment = new OrderDeplacment([
            'localiastion' => $request->localiastion,
            'titel' => $request->titel,
            'buteDeplacment' => $request->buteDeplacment,
            'id_employee' => $request->id_employee,
        ]);

        // Save the OrderDeplacment to the database
        $orderDeplacment->save();

        // Return a response
        return response()->json(['message' => 'OrderDeplacment created successfully'], 201);
    }

    //FETCH ORDER DEPLACMENT

    public function fetchOrderDeplacmentsForEmployee(Request $request)
    {
        $id_employee = $request->input('id_employee', $request->id_employee); // Default to 40 if not provided

        $orderDeplacments = OrderDeplacment::where('id_employee', $id_employee)->get();

        return response()->json(['order_deplacments' => $orderDeplacments], 200);
    }

   
}
