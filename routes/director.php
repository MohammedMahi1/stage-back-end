<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Directory\DirectorController;



Route::get('/',[DirectorController::class,'index']);


Route::post('/addSuperAdmin',[DirectorController::class,'addSuperAdmin']);
