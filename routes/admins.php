<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\admins\AdminAdministrativeController;
use App\Http\Controllers\Auth\admins\AdminFinancieresController;
use App\Http\Controllers\Auth\admins\AdminTechniquesController;


Route::get('/administrative', [AdminAdministrativeController::class, 'index']);
Route::get('/finenciere', [AdminFinancieresController::class, 'index']);
Route::get('/technique', [AdminTechniquesController::class, 'index']);

//================ login administrative =================//
Route::post('/administrative/login', [AdminAdministrativeController::class, 'login'])->middleware('guest:sanctum');
Route::delete('/administrative/logout/{token?}',[AdminAdministrativeController::class,'logout']);
//================ login finenciere =================//
Route::post('/finenciere/login', [AdminFinancieresController::class, 'login'])->middleware('guest:sanctum');
Route::delete('/finenciere/logout/{token?}',[AdminFinancieresController::class,'logout']);
//Route::post('/finenciere/addImageProfile',[AdminAdministrativeController::class,'addImageProfile']);



Route::post('/administrative/addImageProfile',[AdminAdministrativeController::class,'addImageProfile']);

