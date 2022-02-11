<?php

namespace App\Repository;

use App\Http\Services\PaginateService;
use App\Models\Attendance;

class AttendanceRepository implements IModelRepository
{
    private Attendance $model;
    private PaginateService $paginateService;

    public function __construct(Attendance $attendance, PaginateService $paginateService)
    {
        $this->model = $attendance;
        $this->paginateService = $paginateService;
    }

    public function create(array $payload)
    {
        $data = $this->makePayloadDoctor($payload);

        return $this->model->create($data);
    }

    public function patientHaveAttendances(int $patientId)
    {

    }

    public function getAttendancesToPatient(int $patientId)
    {
        return $this->model->where('patient_id', $patientId)->orderBy('entryDate')->get();
    }

    public function getOpenAttendancesToDoctor(int $doctorId, int $paginate)
    {
        $rows = $this->paginateService->paginateAllAttendancesToDoctor($paginate);

        return $this->model
            ->where('doctor_id', $doctorId)
            ->whereNull('exitDate')
            ->skip($rows['skip'])
            ->take($rows['take'])
            ->orderBy('entryDate')
            ->get();
    }

    public function getClosedAttendancesToDoctor(int $doctorId, int $paginate)
    {
        $rows = $this->paginateService->paginateAllAttendancesToDoctor($paginate);

        return $this->model
            ->where('doctor_id', $doctorId)
            ->whereNotNull('exitDate')
            ->skip($rows['skip'])
            ->take($rows['take'])
            ->orderBy('entryDate')
            ->get();
    }

    public function getAllAttendancesToDoctor(int $doctorId, int $paginate)
    {
        $rows = $this->paginateService->paginateAllAttendancesToDoctor($paginate);

        return $this->model
            ->where('doctor_id', $doctorId)
            ->skip($rows['skip'])
            ->take($rows['take'])
            ->orderBy('entryDate')
            ->get();
    }

    public function makePayloadDoctor(array $payload): array
    {
        return [
            'doctor_id' => auth()->id(),
            'patient_id' => $payload['patient_id'],
            'entryDate' => $payload['entryDate'],
            'description' => $payload['description']
        ];
    }

    public function attendanceBelongsToDoctor(int $doctorId, int $attendanceId): bool
    {
        $attendance = $this->model->where('doctor_id', $doctorId)->where('id', $attendanceId)->get();

        if($attendance->all() == [])
            return false;

        return true;
    }

    public function finishAttendance(int $attendanceId, $exitDate)
    {
        $attendance = $this->model->find($attendanceId);

        if(!$attendance->exitDate == null)
            return false;

        $attendance->exitDate = $exitDate;

        $attendance->save();

        return $attendance;
    }

    public function attendanceModelToFormatResponse($attendances)
    {

        if(count($attendances->all()) == 0)
            return [
                'message' => 'No attendances register!'
            ];

        return $attendances->map(function ($attendances)
        {
            return [
                'doctor' => $attendances->doctor->name,
                'entryDate' => $attendances->entryDate,
                'exitDate' => $attendances->exitDate ? $attendances->exitDate : 'Not closed!',
                'description' => $attendances->description
            ];
        });
    }
}
