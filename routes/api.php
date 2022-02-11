<?php

use App\Http\Controllers\Attendance\AttendanceController;
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

Route::get('/login', function ()
{
    return response()->json(['error' => 'Unauthorized'], 401);
})->name('login');

Route::prefix('register')->group(function ()
{
    Route::post('doctor', [RegisterDoctorController::class, 'postRegisterDoctor'])
        ->name('registerDoctor');

    Route::post('patient', [RegisterPatientController::class, 'postRegisterPatient'])
    ->name('registerPatient');

    Route::post('attendance', [RegisterAttendanceController::class, 'postRegisterAttendance'])
        ->name('registerAttendance')
        ->middleware('auth:doctors');
});

Route::prefix('auth')->group(function () {
    Route::post('login/{provider}', [AuthController::class, 'login'])
        ->name('auth.login')
        ->where('provider', '[A-Za-z]+');

    Route::post('logout/{provider}', [AuthController::class, 'logout'])
        ->name('auth.logout');
});


Route::middleware('auth:doctors')->group(function (){
    Route::post('attendances/open/{paginate?}', [AttendanceController::class, 'openAttendanceByDoctor'])
        ->where('paginate', '[1-9]+')
        ->name('openAttendancesByDoctor');

    Route::post('attendances/closed/{paginate?}', [AttendanceController::class, 'closedAttendancesByDoctor'])
        ->where('paginate', '[1-9]+')
        ->name('closedAttendancesByDoctor');

    Route::post('attendances/all/{paginate?}', [AttendanceController::class, 'allAttendancesByDoctor'])
        ->where('paginate', '[1-9]+')
        ->name('allAttendancesByDoctor');

    Route::post('attendance/{id}/finish', [AttendanceController::class, 'finishAttendance'])
        ->where('id', '[1-9]+')
        ->name('finishAttendance');
});

Route::middleware('auth:patients')->group(function ()
{
    Route::post('myAttendances', [AttendanceController::class, 'attendanceByPatient'])
        ->middleware('auth:patients')
        ->name('attendanceByPatient');;
});
