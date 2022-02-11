<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Repository\AttendanceRepository;
use Illuminate\Http\Request;
use function auth;
use function dd;

class AttendanceController extends Controller
{
    private AttendanceRepository $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }


    //todo: routes by provider (equals functions)
    public function attendanceByPatient(): \Illuminate\Http\JsonResponse
    {
        $attendances = $this->attendanceRepository->getAttendancesToPatient(auth()->id());

        $response = $this->attendanceRepository->attendanceModelToFormatResponse($attendances);

        return response()->json($response);
    }

    public function openAttendanceByDoctor(int $paginate = 1)
    {
        $attendances = $this->attendanceRepository->getOpenAttendancesToDoctor(auth()->id(), $paginate);

        $response = $this->attendanceRepository->attendanceModelToFormatResponse($attendances);

        return response()->json($response);
    }

    public function closedAttendancesByDoctor(int $paginate = 1)
    {
        $attendances = $this->attendanceRepository->getClosedAttendancesToDoctor(auth()->id(), $paginate);

        $response = $this->attendanceRepository->attendanceModelToFormatResponse($attendances);

        return response()->json($response);
    }

    public function allAttendancesByDoctor(int $paginate = 1)
    {
        $attendances = $this->attendanceRepository->getAllAttendancesToDoctor(auth()->id(), $paginate);

        $response = $this->attendanceRepository->attendanceModelToFormatResponse($attendances);

        return response()->json($response);
    }

    public function finishAttendance(int $attendanceId, Request $request)
    {
        if(!$this->attendanceRepository->attendanceBelongsToDoctor(auth()->id(), $attendanceId))
            return response()->json([
               'message' => 'This attendance does not belongs to this doctor'
            ], 401);

        $request->validate([
            'exitDate' => ['required', 'date']
        ]);

        $attendance = $this->attendanceRepository->finishAttendance($attendanceId, $request['exitDate']);

        if(!$attendance)
            return response()->json([
                'message' => 'The attendance already closed'
            ]);

        return response()->json([
           'message' => 'The attendance now has a date of exit',
            [
                'doctor' => $attendance->doctor->name,
                'entryDate' => $attendance->entryDate,
                'exitDate' => $attendance->exitDate,
                'description' => $attendance->description
            ]
        ]);
    }
}
