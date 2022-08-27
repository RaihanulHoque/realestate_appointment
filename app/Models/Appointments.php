<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $fillable = [
        'contact_id',
        'appointment_address',
        'measured_distance',
        'appointment_date',
        'appointment_start_time',
        'departure_time_to_site_office',
        'appointment_end_time',
        'arrival_time_to_agent_office',
    ];


    //Belongs to Contact
    public function contacts()
    {
      return $this->belongsTo(Contacts::class);
    }
    //Belongs to Agent User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Calculating Distance Between Agent Office Address and Appointment Address
    // THE API KEY I USED is not activated, to get actual values from this function a VALID API KEY Should be used
    public static function getGoogleMapInfo($zip1, $zip2)
    {
      $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$zip1."&destinations=".$zip2."&key=API_KEY");
      $data = json_decode($api);
      return $data;
    }

}
