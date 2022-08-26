<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppointmentController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->appointment()->get()->toArray();
    }

    public function show($id)
    {
        $appointment = $this->user->appointment()->find($id);
    
        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Appointment cannot found'
            ], 400);
        }
    
        return $appointment;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'contact_id' => 'required|integer',
            'appointment_date' => 'required',
            'appointment_start_time' => 'required',
            'appointment_address' => 'required|string|max:6'
        ]);
    
        $appointment = new Appointments(); 
        $appointment->user_id= $request->user()->id;
        $appointment->contact_id= $request->contact_id;
        $appointment->appointment_address= $request->appointment_address;
        $agen_office_address = $request->user()->address;
        //Measuring the distance between Agent Office and the Appointment address
        $map_calculation = Appointments::getGoogleMapInfo($request->appointment_address, $agen_office_address);
        $distance = ((int)$map_calculation->rows[0]->elements[0]->distance->value / 1000).' Km';
        $duration = $map_calculation->rows[0]->elements[0]->duration->text;
        
        $appointment->measured_distance= $distance;
        $appointment->appointment_date= $request->appointment_date;

        $appoint_start_time = $request->appointment_start_time;
        
        $strTime = strtotime($appoint_start_time);
        // $startTime = date("H:i:s", strtotime('-30 minutes', $strTime));
        $negativeTime = '-'.$duration;
        $estimatedDepartTime = date("H:i:s", strtotime($negativeTime, $strTime));


        $appointment->appointment_start_time= $appoint_start_time;
        $appointment->departure_time_to_site_office= $estimatedDepartTime; //Calculate by GOOGLE API 

        $appoint_end_time = $request->appointment_end_time;
        $appointment->appointment_end_time= $appoint_end_time;
        $appointment->departure_time_to_agent_office= $appoint_end_time;

        if ($this->user->appointment()->save($appointment))
            return response()->json([
                'success' => true,
                'appointment' => $appointment
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Appointment could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $appointment = $this->user->appointment()->find($id);
    
        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Appointment with id ' . $id . ' cannot be found'
            ], 400);
        }
        
        $updated = $appointment->fill($request->all())
            ->save();
        
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Appointment could not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $appointment = $this->user->appointment()->find($id);
    
        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Appointment with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($appointment->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Appointment could not be deleted'
            ], 500);
        }
    }


}
