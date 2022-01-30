<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAttendanceRequest;
use App\Models\Attendance;

class RegisterAttendanceController extends Controller
{
    private Attendance $attendanceRepository;

    public function __construct(Attendance $attendance)
    {
        $this->attendanceRepository = $attendance;
    }

    public function postRegisterAttendance(RegisterAttendanceRequest $request)
    {
        $attendance = $this->attendanceRepository->create($request->all());

        return response()->json([
            'message' => 'success',
            'patientName' => $attendance->patient->name,
            'doctorName' => $attendance->doctor->name,
            'entryDate' => $attendance->entryDate,
            'description' => $attendance->description
        ]);
    }
}
