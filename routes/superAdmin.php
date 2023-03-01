<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\admins\SuperAdminController;

Route::get('/',[SuperAdminController::class,'index']);
Route::post('/login',[SuperAdminController::class,'login'])->middleware('guest:sanctum');
Route::delete('/logout/{token?}',[SuperAdminController::class,'logout']);


// Add-Edit-Delete => Employe
Route::post('/addEmploye',[SuperAdminController::class,'addEmploye']);
Route::put('/editEmploye/{id}',[SuperAdminController::class,'editEmploye']);
Route::delete('/deleteEmploye/{id}',[SuperAdminController::class,'deleteEmploye']);

// Add-Edit-Delete => Admin Administrative
Route::post('/addAdministrative',[SuperAdminController::class,'addAdministrative']);
Route::put('/editAdministrative/{id}',[SuperAdminController::class,'editAdministrative']);
Route::delete('/deleteAdministrative/{id}',[SuperAdminController::class,'deleteAdministrative']);

// Add-Edit-Delete => Admin Financieres
Route::post('/addFinancieres',[SuperAdminController::class,'addFinancieres']);
Route::put('/editFinancieres/{id}',[SuperAdminController::class,'editFinancieres']);
Route::delete('/deleteFinancieres/{id}',[SuperAdminController::class,'deleteFinancieres']);

// Add-Edit-Delete => Admin Techniques
Route::post('/addTechniques',[SuperAdminController::class,'addTechniques']);
Route::put('/editTechniques/{id}',[SuperAdminController::class,'editTechniques']);
Route::delete('/deleteTechniques/{id}',[SuperAdminController::class,'deleteTechniques']);
