<?php

use App\Helper\JWTToken;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
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

// User API Route for Backend
Route::post( '/user-registration', [UserController::class, 'UserRegistration'] );
Route::post( '/user-login', [UserController::class, 'UserLogin'] );
Route::post( '/send-otp', [UserController::class, 'SendOTPCode'] );
Route::post( '/verify-otp', [UserController::class, 'VerifyOTP'] );
Route::post( '/reset-password', [UserController::class, 'ResetPassword'] )->middleware([TokenVerificationMiddleware::class]);
Route::get( '/user-profile', [UserController::class, 'UserProfile'] )->middleware([TokenVerificationMiddleware::class]);
Route::post( '/user-update', [UserController::class, 'UpdateProfile'] )->middleware([TokenVerificationMiddleware::class]);

// Category API Route for Backend
Route::post('/create-category',[CategoryController::class,'CategoryCreate'])->middleware(TokenVerificationMiddleware::class);
Route::get('/list-category',[CategoryController::class,'CategoryList'])->middleware(TokenVerificationMiddleware::class);
Route::post('/update-category',[CategoryController::class,'CategoryUpdate'])->middleware(TokenVerificationMiddleware::class);
Route::post('/delete-category',[CategoryController::class,'CategoryDelete'])->middleware(TokenVerificationMiddleware::class);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware(TokenVerificationMiddleware::class);
// Route::get('/total-category',[CategoryController::class,'CategoryTotal'])->middleware(TokenVerificationMiddleware::class);

// Customer API Route for Backend
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware(TokenVerificationMiddleware::class);
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware(TokenVerificationMiddleware::class);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware(TokenVerificationMiddleware::class);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware(TokenVerificationMiddleware::class);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware(TokenVerificationMiddleware::class);



// Page Routes
// Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout',[UserController::class,'UserLogout'])->middleware(TokenVerificationMiddleware::class);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);





// check JWT Token from verify token function  extra route
Route::get( '/token', function ( ) {return JWTToken::VerifyToken( 'past your token');});
