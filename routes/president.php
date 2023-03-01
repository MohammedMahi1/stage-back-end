<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\PresidentController;

Route::get('/',[PresidentController::class,'index']);
Route::post('/addDirector',[PresidentController::class,'addDirector']);
