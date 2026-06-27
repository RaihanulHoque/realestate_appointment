<?php

namespace App\Services;

class AppointmentSchedulingService
{
    private const DEFAULT_APPOINTMENT_DURATION = '+1 Hour';

    /**
     * Estimate travel distance/duration between the agent's office and the
     * appointment address. Without a valid Google Maps API key this returns
     * static placeholder values; swap in fetchGoogleDistanceMatrix() once a
     * real key is configured.
     */
    public function estimateTravel(string $officeAddress, string $appointmentAddress): array
    {
        return [
            'distance' => '2km',
            'duration_to_site' => '30 minutes',
            'duration_to_office' => '40 minutes',
        ];
    }

    /**
     * Build the derived schedule fields (departure/end/arrival times) from
     * the appointment start time and estimated travel durations.
     */
    public function buildSchedule(string $appointmentStartTime, string $travelDurationToSite, string $travelDurationToOffice): array
    {
        $startTimestamp = strtotime($appointmentStartTime);

        $departureTimeToSiteOffice = date('H:i:s', strtotime('-'.$travelDurationToSite, $startTimestamp));
        $appointmentEndTime = date('H:i:s', strtotime(self::DEFAULT_APPOINTMENT_DURATION, $startTimestamp));
        $arrivalTimeToAgentOffice = date('H:i:s', strtotime('+'.$travelDurationToOffice, strtotime($appointmentEndTime)));

        return [
            'appointment_start_time' => $appointmentStartTime,
            'departure_time_to_site_office' => $departureTimeToSiteOffice,
            'appointment_end_time' => $appointmentEndTime,
            'arrival_time_to_agent_office' => $arrivalTimeToAgentOffice,
        ];
    }

    /**
     * Real Google Distance Matrix lookup. Not currently called anywhere —
     * requires a valid API key in config/services.php. Moved here from
     * Appointments::getGoogleMapInfo() so the model stays a data container.
     */
    public function fetchGoogleDistanceMatrix(string $origin, string $destination)
    {
        $apiKey = config('services.google_maps.key');

        $response = file_get_contents(
            'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='
            . urlencode($origin) . '&destinations=' . urlencode($destination) . '&key=' . $apiKey
        );

        return json_decode($response);
    }
}
