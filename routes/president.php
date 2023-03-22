<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\PresidentController;

Route::get('/',[PresidentController::class,'index']);
Route::post('/addDirector',[PresidentController::class,'addDirector']);

Route::post('/login',[PresidentController::class,'login'])->middleware('guest:sanctum');
Route::post('/create',[PresidentController::class,'createacc'])->middleware('guest:sanctum');
Route::delete('/logout/{token?}',[PresidentController::class,'logout']);

