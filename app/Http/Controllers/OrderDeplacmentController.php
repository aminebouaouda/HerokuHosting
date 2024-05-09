<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDeplacment; // Ensure you import the OrderDeplacment model here
use App\Models\Charges; // Ensure you import the OrderDeplacment model here
use App\Models\User; // Import the User model


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

    // ADD CHARGES 

    public function addCharges(Request $request)
{
    $request->validate([
        'id_order_deployment' => 'required',
        'id_employee' => 'required',
        'budget_total' => 'required|numeric',
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image in the array
    ]);

    $imagePaths = [];
    foreach ($request->file('images') as $image) {
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/upload/images'), $new_name); // Move each image to the specified directory
        $imagePaths[] =  $new_name; // Store the image paths
    }

    $charge = new Charges([
        'id_order_deployment' => $request->id_order_deployment,
        'id_employee' => $request->id_employee,
        'budget_total' => $request->budget_total,
        'images' => json_encode($imagePaths), // Store the array of image paths as JSON
    ]);

    $charge->save();

    return response()->json(['message' => 'Charge created successfully'], 200);
}

    //FETCH CHARGER
    public function getAllCharges(Request $request)
{
    // Fetch charges where id_order_deployment is equal to 10
    $charges = Charges::where('id_order_deployment',$request->OrderID)->get();
    
    return response()->json(['charges' => $charges], 200);

}
   

    // SELECT ALL ODERDER DE DEPLACMENT

    public function fetchOrderDeplacmentsForCompany(Request $request)
    {
        // Fetch all order_deplacments with associated user details and filter by company name
        $orderDeplacments = OrderDeplacment::join('users', 'order_deplacments.id_employee', '=', 'users.id')
            ->where('users.CompanyName', $request->CompanyName)
            ->select('order_deplacments.*')
            ->get();
    
        if ($orderDeplacments->isEmpty()) {
            return response()->json(['message' => 'No order deplacments exist for the company'], 404);
        }
    
        return response()->json(['order_deplacments' => $orderDeplacments], 200);
    }

    //ACCEPTER ORDER DEPLACMENT

    public function acceptOrderDeplacment(Request $request)
{
    $orderDeplacment = OrderDeplacment::find($request->OrderID);

    if (!$orderDeplacment) {
        return response()->json(['error' => 'Order deplacment not found'], 404);
    }

    $orderDeplacment->update(['is_accepte' => 1]);

    return response()->json(['message' => 'Order deplacment accepted successfully'], 200);
}

    //DELET OREDER 

    public function deleteOrderDeplacment(Request $request)
{
    try {
        // Find the order by ID
        $orderId = $request->orderid;
        $order = OrderDeplacment::find($orderId);

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Delete the order
        $order->delete();

        // Return a success response
        return response()->json(['message' => 'Order deleted successfully'], 200);
    } catch (\Exception $e) {
        // Return an error response if deletion fails
        return response()->json(['error' => 'Failed to delete order'], 500);
    }
}

//ADD LOCALISATION VERIFY 
public function updateLocalisationVerify(Request $request)
{
    try {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required',
        ]);

        // Find the order by ID
        $orderId = $request->id;
        $order = OrderDeplacment::find($orderId);

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update the localisation_verify column to "agadir"
        $order->update(['localisation_verify' => $request->localisation_verify,'fine_mission' => 1]);
        

        // Return a success response
        return response()->json(['message' => 'Localisation updated successfully'], 200);
    } catch (\Exception $e) {
        // Return an error response if update fails
        return response()->json(['error' => 'Failed to update localisation'], 500);
    }
}

// FINE MISSION
public function FineMession(Request $request)
{
    try {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required',
        ]);

        // Find the order by ID
        $orderId = $request->id;
        $order = OrderDeplacment::find($orderId);

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update the localisation_verify column to "agadir"
        $order->update(['mession_verify' => 1]);
        

        // Return a success response
        return response()->json(['message' => 'Mission finished successfully'], 200);
    } catch (\Exception $e) {
        // Return an error response if update fails
        return response()->json(['error' => 'Failed to finish mission'], 500);
    }
}

}
