<?php

use App\Helper\JWTToken;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// API Route
Route::post( '/user-registration', [UserController::class, 'UserRegistration'] );
Route::post( '/user-login', [UserController::class, 'UserLogin'] );
Route::post( '/send-otp', [UserController::class, 'SendOTPCode'] );
Route::post( '/verify-otp', [UserController::class, 'VerifyOTP'] );
Route::post( '/reset-password', [UserController::class, 'ResetPassword'] )->middleware([TokenVerificationMiddleware::class]);

// check JWT Token from verify token function 
Route::get( '/token', function ( ) {return JWTToken::VerifyToken( 'past your token');});

// Page Routes
Route::get('/',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage']);

Route::get('/dashboard',[DashboardController::class,'DashboardPage']);