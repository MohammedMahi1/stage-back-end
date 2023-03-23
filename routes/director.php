<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\DirectorController;

Route::post('/login',[DirectorController::class,'login'])->middleware('guest:sanctum');
Route::delete('/logout/{token?}',[DirectorController::class,'logout']);
Route::post('/create',[DirectorController::class,'createacc'])->middleware('guest:sanctum');

Route::get('/',[DirectorController::class,'index']);
Route::post('/addSuperAdmin',[DirectorController::class,'addSuperAdmin']);
Route::post('/addImageProfile',[DirectorController::class,'addImageProfile']);
