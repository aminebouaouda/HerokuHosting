<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Director_Services_Controller;
use App\Http\Controllers\Emplyee_Services_Controller;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\ResourceController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', [AuthController::class, 'test']);

Route::post('/createCompte', [AuthController::class, 'createCompte']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/profile', [AuthController::class, 'profile']);
Route::post('/checkEmail', [AuthController::class, 'checkEmail']);
Route::post('/checkCompanyName', [AuthController::class, 'checkCompanyName']);

//Services Dericture
Route::post('/AddEmployee', [Director_Services_Controller::class, 'AddEmployee']);
Route::post('/DropEmployee', [Director_Services_Controller::class, 'DropEmployee']);
Route::post('/FetchEmployee', [Director_Services_Controller::class, 'FetchEmployee']);
Route::post('/uploadimage', [Director_Services_Controller::class, 'uploadimage']);
Route::post('/getEmployeesNotClockedIn', [Director_Services_Controller::class, 'getEmployeesNotClockedIn']);
Route::post('/getEmployeesWithTimeEntry', [Director_Services_Controller::class, 'getEmployeesWithTimeEntry']);
Route::post('/getEmploiyeesTakebreak', [Director_Services_Controller::class, 'getEmploiyeesTakebreak']);
Route::post('/getEmploiyeesAfterBreak', [Director_Services_Controller::class, 'getEmploiyeesAfterBreak']);
Route::post('/getEmployeeLeave', [Director_Services_Controller::class, 'getEmployeeLeave']);
Route::post('/AddProject', [Director_Services_Controller::class, 'AddProject']);
Route::post('/fetchProjects', [Director_Services_Controller::class, 'fetchProjects']);
Route::post('/DeleteProject', [Director_Services_Controller::class, 'DeleteProject']);

//Pointage
Route::post('/pointage', [Emplyee_Services_Controller::class, 'pointage']);
Route::post('/updatePauseExit', [Emplyee_Services_Controller::class, 'updatePauseExit']);
Route::post('/updatePauseEntry', [Emplyee_Services_Controller::class, 'updatePauseEntry']);
Route::post('/TimeExite', [Emplyee_Services_Controller::class, 'TimeExite']);

Route::post('/AddVacation', [VacationController::class, 'AddVacation']);
Route::post('/employeeVacations', [VacationController::class, 'employeeVacations']);
Route::post('/updateVacation', [VacationController::class, 'updateVacation']);
Route::post('/deleteVacation', [VacationController::class, 'deleteVacation']);

//the director manage the vactiosn
Route::post('/approveOrRejectVacation', [VacationController::class, 'approveOrRejectVacation']);
Route::get('/fetchEmployeeVacations', [VacationController::class, 'fetchEmployeeVacations']);
// Route::get('/FetchUserByEmployeeId', [VacationController::class, 'fetchUserByEmployeeId']);
Route::get('/FetchUserByEmployeeId/{userId}', [VacationController::class, 'fetchUserByEmployeeId']);

// Route::get('/fetchUserByEmployeeId/{employeeId}', 'UserController@fetchUserByEmployeeId');



//handle profile
Route::get('/fetchAuthenticatedUserData/{userId}', [Director_Services_Controller::class, 'fetchAuthenticatedUserData']);


// Route::delete('/payments/{paymentId}', 'PaymentController@deletePayment');


// Route::get('/fetchPayments'
//paiment 
Route::post('/paymentsAdd', [ResourceController::class, 'addPayment']);
Route::get('/fetchPayments', [ResourceController::class, 'fetchPayments']);
Route::delete('/deletePayments/{paymentId}', [ResourceController::class, 'deletePayments']);
// Route::delete('/deletePayments/{paymentId}', [ResourceController::class, 'deletePayments']);
Route::put('/updatePaymentStatus/{paymentId}', [ResourceController::class, 'updatePaymentStatus']);


//paiemnt mode
Route::post('/addPayment_modes', [ResourceController::class, 'addPaymentMode']);
Route::get('/fetchPayment_modes', [ResourceController::class, 'fetchPaymentModes']);
// Route::post('/deletePayment_modes/delete/{id}', [ResourceController::class, 'deletePaymentMode']);
// Route::delete('/deletepayment_modes/{id}', [ResourceController::class, 'deletePaymentMode'])->name('payment_modes.delete');
// Route::post('/payment_modes/delete/{id}', 'PaymentModeController@deletePaymentMode');
Route::delete('/deletePayment_modes/{id}',[ResourceController::class, 'deletePaymentMode']);


//facture
Route::post('/addInvoices',[ResourceController::class, 'addInvoices']);
Route::get('/fetchInvoices',[ResourceController::class, 'fetchInvoices']);

Route::delete('/deleteInvoice/{id}', [ResourceController::class, 'deleteInvoice']);
// Route::get('/fetchInvoices', 'App\Http\Controllers\InvoiceController@fetchInvoices');
