<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PhoneNumberController;

Route::get("/hell", [PhoneNumberController::class, 'hello']);
Route::get("/{phoneNumber}", [PhoneNumberController::class, 'savePhoneNumber']);
Route::post("/deleteUser", [UserController::class, 'deleteUser']);
Route::post("/addUser", [UserController::class, 'addUser']);
Route::post("/sendOtpForDeletion", [UserController::class, 'sendOtpForDeletion']);
Route::post("/verifyOtpForDeletion", [UserController::class, 'verifyOtpForDeletion']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


