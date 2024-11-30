<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource("/user",UserController::class);
Route::put("/user/{uuid}/update", [UserController::class,"updateByUUID"]);
Route::delete("/user/{uuid}/delete", [UserController::class,"deleteByUUID"]);