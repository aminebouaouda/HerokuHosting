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

Route::post('/AddEmployee', [Director_Services_Controller::class, 'AddEmployee']);
Route::post('/DropEmployee', [Director_Services_Controller::class, 'DropEmployee']);
Route::post('/FetchEmployee', [Director_Services_Controller::class, 'FetchEmployee']);
Route::post('/uploadimage', [Director_Services_Controller::class, 'uploadimage']);

Route::post('/pointage', [Emplyee_Services_Controller::class, 'pointage']);
Route::post('/updatePauseExit', [Emplyee_Services_Controller::class, 'updatePauseExit']);
Route::post('/updatePauseEntry', [Emplyee_Services_Controller::class, 'updatePauseEntry']);

Route::post('/AddVacation', [VacationController::class, 'AddVacation']);

