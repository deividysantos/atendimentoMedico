<?php

use App\Http\Controllers\Doctor\AuthDoctorController;
use App\Http\Controllers\Doctor\RegisterDoctorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register/doctor', [RegisterDoctorController::class, 'postRegisterDoctor'])->name('registerDoctor');

Route::post('auth/login/doctor', [AuthDoctorController::class, 'login'])->name('auth.login.doctor');

Route::group([ 'middleware' => 'auth-jwt', 'prefix' => 'auth' ], function ()
{
    Route::post('logout', [AuthDoctorController::class, 'logout'])->name('logout');
});
