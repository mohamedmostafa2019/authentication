<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ProfileController;

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

Route::middleware(['auth:sanctum'])->group(function(){
    
    Route::get('/profile',function(Request $request){ 
         return $request->user();
    
    
    });
    

});

   


//register
Route::post('/register',[RegisterController::class,'register']);

//login
Route::post('/loginForm',[LoginController::class,'LoginForm']);


Route::get('/mail' ,[TestController::class,'mail']);
Route::put('/profileUser' ,[ProfileController::class,'UpdateProfile']);


//forgetPassword
Route::post('/ForgetPassword',[ForgetPasswordController::class,'forgetPassword']);
//resetPassword
Route::post('/ResetPassword',[ResetPasswordController::class,'PasswordReset']);


//email_verified
Route::post('/email_verified' ,[EmailVerificationController::class,'EmailVerificationValidate']);

// sendEmailVerification
Route::get('/sendEmailVerification' ,[EmailVerificationController::class,'sendEmailVerification'])->middleware('auth:sanctum');


