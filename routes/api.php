<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Director_Services_Controller;
use App\Http\Controllers\Emplyee_Services_Controller;
use App\Http\Controllers\VacationController;


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

// Route::post('/addVacation', [VacationController::class, 'AddVacation']);
// Route::post('/updateVacation', [VacationController::class, 'UpdateVacation']);
// Route::post('/deleteVacation', [VacationController::class, 'DeleteVacation']);
// Route::post('/fetchVacation', [VacationController::class, 'FetchVacation']);
//the authentifacted eprson shoudl use to send a vaction demand to the adminstartor
// Route::middleware('auth')->group(function () {
//     Route::post('/addVacation', [VacationController::class, 'AddVacation']);
//     Route::post('/updateVacation', [VacationController::class, 'UpdateVacation']);
//     Route::post('/deleteVacation', [VacationController::class, 'DeleteVacation']);
//     Route::post('/fetchVacation', [VacationController::class, 'FetchVacation']);
// });
