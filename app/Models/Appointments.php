<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $fillable = [
        'contact_id',
        'user_id',
        'appointment_address',
        'measured_distance',
        'appointment_date',
        'appointment_start_time',
        'departure_time_to_site_office',
        'appointment_end_time',
        'departure_time_to_agent_office',
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
    //Calculating Distance Between Agen Office Address and Appointment Address
    public static function getGoogleMapInfo($zip1, $zip2)
    {
      $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$zip1."&destinations=".$zip2."&key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxSPW5CJgpdgO_s4yyMovOaVh_KvvhSfpvagV18eOyDWu7VytS6Bi1CWxw");
      $data = json_decode($api);
      return $data;
    }

    // This function returns Longitude & Latitude from zip code.
    public function getLnt($zip){
      $url = "https://maps.googleapis.com/maps/api/geocode/json?address=
      ".urlencode($zip)."&sensor=false&key=[YOUR API KEY]";
      $result_string = file_get_contents($url);
      $result = json_decode($result_string, true);
      $result1[]=$result['results'][0];
      $result2[]=$result1[0]['geometry'];
      $result3[]=$result2[0]['location'];
      return $result3[0];
      } 
      
    public static function getDistance($zip1, $zip2, $unit){
      $first_lat = getLnt($zip1);
      $next_lat = getLnt($zip2);
      $lat1 = $first_lat['lat'];
      $lon1 = $first_lat['lng'];
      $lat2 = $next_lat['lat'];
      $lon2 = $next_lat['lng']; 
      $theta=$lon1-$lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
      cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
      cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);
      
      if ($unit == "K"){
      return ($miles * 1.609344)." ".$unit;
      }
      else if ($unit =="N"){
      return ($miles * 0.8684)." ".$unit;
      }
      else{
      return $miles." ".$unit;
      }
      
  }
}
