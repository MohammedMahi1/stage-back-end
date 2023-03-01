<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\admins\AdminAdministrativeController;
use App\Http\Controllers\Auth\admins\AdminFinancieresController;
use App\Http\Controllers\Auth\admins\AdminTechniquesController;

Route::get('/administrative', [AdminAdministrativeController::class, 'index']);
Route::get('/financiere', [AdminFinancieresController::class, 'index']);
Route::get('/technique', [AdminTechniquesController::class, 'index']);
