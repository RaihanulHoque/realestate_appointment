<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Services\AppointmentSchedulingService;
use App\Http\Resources\AppointmentResource;
use App\Traits\ApiResponser;

class AppointmentController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return AppointmentResource::collection($request->user()->appointments()->get());
    }

    public function show(Request $request, $id)
    {
        $appointment = $request->user()->appointments()->find($id);

        if (!$appointment) {
            return $this->notFoundResponse('appointment', $id);
        }

        $this->authorize('view', $appointment);

        return new AppointmentResource($appointment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentRequest $request, AppointmentSchedulingService $scheduler)
    {
        $travel = $scheduler->estimateTravel($request->user()->address, $request->appointment_address);
        $schedule = $scheduler->buildSchedule(
            $request->appointment_start_time,
            $travel['duration_to_site'],
            $travel['duration_to_office']
        );

        $appointment = new Appointments();
        $appointment->user_id = $request->user()->id;
        $appointment->contact_id = $request->contact_id;
        $appointment->appointment_address = str_replace(' ', '', $request->appointment_address);
        $appointment->appointment_date = $request->appointment_date;
        $appointment->measured_distance = $travel['distance'];
        $appointment->fill($schedule);

        if ($request->user()->appointments()->save($appointment)) {
            return $this->successResponse(['appointment' => new AppointmentResource($appointment)]);
        }

        return $this->errorResponse('Sorry, appointment could not be added', 500);
    }

    public function update(UpdateAppointmentRequest $request, $id, AppointmentSchedulingService $scheduler)
    {
        $appointment = $request->user()->appointments()->find($id);
        if (!$appointment) {
            return $this->notFoundResponse('appointment', $id);
        }

        $this->authorize('update', $appointment);

        $appointment->fill($request->validated());

        if ($request->filled('appointment_start_time')) {
            $travel = $scheduler->estimateTravel($request->user()->address, $appointment->appointment_address);
            $appointment->measured_distance = $travel['distance'];
            $appointment->fill($scheduler->buildSchedule(
                $appointment->appointment_start_time,
                $travel['duration_to_site'],
                $travel['duration_to_office']
            ));
        }

        $updated = $appointment->save();

        if ($updated) {
            return $this->successResponse();
        }

        return $this->errorResponse('Sorry, appointment could not be updated', 500);
    }

    public function destroy(Request $request, $id)
    {
        $appointment = $request->user()->appointments()->find($id);

        if (!$appointment) {
            return $this->notFoundResponse('appointment', $id);
        }

        $this->authorize('delete', $appointment);

        if ($appointment->delete()) {
            return $this->successResponse();
        }

        return $this->errorResponse('appointment could not be deleted', 500);
    }
}
