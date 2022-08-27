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
        return $this->user->appointments()->get()->toArray();
    }

    public function show($id)
    {
        $appointment = $this->user->appointments()->find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, appointment with cannot be found'
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
            'contact_id' => 'required',
            'appointment_date' => 'required',
            'appointment_address' => 'required|max:7',
            'appointment_start_time' => 'required'
        ]);

        $appointment = new Appointments();
        $appointment->user_id= $request->user()->id;
        $appointment->contact_id= $request->contact_id;
        $appointment->appointment_address= str_replace(' ', '', $request->appointment_address);
        $appointment->appointment_date= $request->appointment_date;

        $agent_office_address = $request->user()->address;

        /*
            //Measuring the distance between Agent Office and the Appointment address
            $map_calculation_to_site_office = Appointments::getGoogleMapInfo($agent_office_address, $request->appointment_address);

            // With a VALID GOOGLE API KEY above function will generate required values below.
            $distance = ((int)$map_calculation_to_site_office->rows[0]->elements[0]->distance->value / 1000).' Km';
            $durationToSiteOffice = $map_calculation_to_site_office->rows[0]->elements[0]->duration->text;
        */

        //As I am not getting values from Google Maps, I am using static values for this instance-
        $distance = '2km';
        $durationToSiteOffice = '30 minutes';

        $appointment->measured_distance= $distance;
        $appoint_start_time = $request->appointment_start_time;

        $strTime = strtotime($appoint_start_time);
        $negativeTime = '-'.$durationToSiteOffice;
        $estimatedDepartTime = date("H:i:s", strtotime($negativeTime, $strTime));
        $appointment->appointment_start_time= $appoint_start_time;
        $appointment->departure_time_to_site_office= $estimatedDepartTime;//Calculated by GOOGLE API

        //By Default Appointment time allocated for 1 hour
        $appointment_end_time = date("H:i:s", strtotime('+1 Hour', $strTime));
        $appointment->appointment_end_time= $appointment_end_time;

        /*
            //Duration Calculation from Site Office to Agent Office
            $map_calculation_to_agent_office = Appointments::getGoogleMapInfo($request->appointment_address, $agent_office_address);
            // With a VALID GOOGLE API KEY above function will generate required values below.
            $durationToAgentOffice = $map_calculation_to_agent_office->rows[0]->elements[0]->duration->text;
        */

        $durationToAgentOffice = '40 minutes';
        $positive_time_value = '+'.$durationToAgentOffice;
        $strTime_end = strtotime($appointment_end_time);
        $estimated_arrival_time = date("H:i:s", strtotime($positive_time_value, $strTime_end));
        $appointment->arrival_time_to_agent_office= $estimated_arrival_time;

        if ($this->user->appointments()->save($appointment))
            return response()->json([
                'success' => true,
                'appointment' => $appointment
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, appointment could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $appointment = $this->user->appointments()->find($id);
        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, appointment with id ' . $appointment . ' cannot be found'
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
                'message' => 'Sorry, appointment could not be updated'
            ], 500);
        }

    }

    public function destroy($id)
    {
        $appointment = $this->user->appointments()->find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, appointment with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($appointment->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'appointment could not be deleted'
            ], 500);
        }
    }


}
