<?php

use App\Http\Controllers\Attendance\RegisterAttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Doctor\RegisterDoctorController;
use App\Http\Controllers\Patient\RegisterPatientController;
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

Route::prefix('register')->group(function ()
{
    Route::post('doctor', [RegisterDoctorController::class, 'postRegisterDoctor'])
        ->name('registerDoctor');

    Route::post('patient', [RegisterPatientController::class, 'postRegisterPatient'])
    ->name('registerPatient');

    Route::post('attendance', [RegisterAttendanceController::class, 'postRegisterAttendance'])
        ->name('registerAttendance');
});

Route::prefix('auth')->group(function ()
{
    Route::post('login/{provider}', [AuthController::class, 'login'])
        ->name('auth.login')
        ->where('provider', '[A-Za-z]+');

    Route::post('logout/{provider}', [AuthController::class, 'logout'])
        ->name('auth.logout')
        ->where('provider', '[A-Za-z]+');
});
