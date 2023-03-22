<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\employe\EmployeController;



Route::post('login',[EmployeController::class,'login'])->middleware('guest:sanctum');
Route::delete('/logout/{token?}',[EmployeController::class,'logout']);


Route::get('/',[EmployeController::class, 'index']);
Route::post('/addArriver',[EmployeController::class, 'addArriver']);
Route::post('/addDepart',[EmployeController::class, 'addDepart']);
Route::post('/addImageProfile',[EmployeController::class,'addImageProfile']);
