<?php

namespace Tests\Unit;

use App\Services\AppointmentSchedulingService;
use Tests\TestCase;

class AppointmentSchedulingServiceTest extends TestCase
{
    public function test_build_schedule_calculates_derived_times()
    {
        $service = new AppointmentSchedulingService();

        $schedule = $service->buildSchedule('10:00:00', '30 minutes', '40 minutes');

        $this->assertEquals('10:00:00', $schedule['appointment_start_time']);
        $this->assertEquals('09:30:00', $schedule['departure_time_to_site_office']);
        $this->assertEquals('11:00:00', $schedule['appointment_end_time']);
        $this->assertEquals('11:40:00', $schedule['arrival_time_to_agent_office']);
    }
}
