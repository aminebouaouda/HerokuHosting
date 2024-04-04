<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Director_Services_Controller;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', [AuthController::class, 'test']);

Route::post('/createCompte', [AuthController::class, 'createCompte']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/AddEmployee', [Director_Services_Controller::class, 'AddEmployee']);
Route::post('/DropEmployee', [Director_Services_Controller::class, 'DropEmployee']);

