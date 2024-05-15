<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\ModePaiement;
use App\Models\Facture;
// use App\Models\Paiement;

class ResourceController extends Controller
{
    // Méthodes pour le modèle User
    public function addPayment(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'employee_id' => 'required|numeric',
            'mode_paiement_id' => 'required|numeric',
            'type_salaire' => 'required|string',
            'periode_paiement' => 'required|string',
            'remarques' => 'string|nullable',
            'statut' => 'string|nullable',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
        ]);

        // Create the payment
        $payment = Paiement::create([
            'employee_id' => $validatedData['employee_id'],
            'mode_paiement_id' => $validatedData['mode_paiement_id'],
            'type_salaire' => $validatedData['type_salaire'],
            'periode_paiement' => $validatedData['periode_paiement'],
            'remarques' => $validatedData['remarques'] ?? null,
            'statut' => $validatedData['statut'] ?? null,
            'montant' => $validatedData['montant'],
            'date_paiement' => $validatedData['date_paiement'],
        ]);

        // Return a response indicating success
        return response()->json(['message' => 'Payment added successfully'], 200);
    }

    public function fetchPayments()
    {
        try {
            $payments = Paiement::all();
            return response()->json($payments, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch payments'], 500);
        }
    }

    //delete a payment
    public function deletePayments($paymentId)
    {
        try {
            $payment = Paiement::findOrFail($paymentId);
            $payment->delete();

            return response()->json(['message' => 'Payment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete payment', 'error' => $e->getMessage()], 500);
        }
    }

    //update Payment status
    public function updatePaymentStatus($paymentId)
    {
        try {
            $payment = Paiement::findOrFail($paymentId);
            $payment->update(['statut' => 'Payé']);

            return response()->json(['message' => 'Payment status updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update payment status'], 500);
        }
    }
    
    public function addPaymentMode(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'mode' => 'required|string',
            'description' => 'required|string',
        ]);

        // Create the payment mode
        $paymentMode = ModePaiement::create([
            'mode' => $validatedData['mode'],
            'description' => $validatedData['description'],
        ]);

        // Return a response indicating success
        return response()->json(['message' => 'Payment mode added successfully'], 200);
    }
    public function deletePaymentMode($id)
    {
        try {
            $paymentMode = ModePaiement::findOrFail($id);
            $paymentMode->delete();
            return response()->json(['message' => 'Payment mode deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete payment mode'], 500);
        }
    }
    public function fetchPaymentModes()
    {
        try {
            $paymentModes = ModePaiement::all();
            return response()->json($paymentModes);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch payment modes'], 500);
        }
    }


    //factures
    public function addInvoices(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'numero' => 'required|string',
            'employee_id' => 'required|integer',
            'paiement_id' => 'required|integer',
            'description' => 'required|string',
            'date_emission' => 'required|date',
            'date_echeance' => 'required|date',
            'montant' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);
    
        // Create a new invoice
        $facture = Facture::create([
            'numero' => $request->numero,
            'employee_id' => $request->employee_id,
            'paiement_id' => $request->paiement_id,
            'description' => $request->description,
            'date_emission' => $request->date_emission,
            'date_echeance' => $request->date_echeance,
            'montant' => $request->montant,
            'notes' => $request->notes,
        ]);
    
        return response()->json(['message' => 'Invoice added successfully', 'invoice' => $facture], 200);
    }

    //ftech invoices or factures
    public function fetchInvoices()
    {
        try {
            $invoices = Facture::all(); // Fetch all invoices
            return response()->json($invoices, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch invoices'], 500);
        }
    }


    //deleet an existing Invoice
    public function deleteInvoice($id)
{
    try {
        $invoice = Facture::findOrFail($id);
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete invoice'], 500);
    }
}
    
}
