<?php

namespace Database\Seeders;

use App\Models\Appointments;
use App\Models\Contacts;
use App\Models\User;
use App\Services\AppointmentSchedulingService;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function __construct(private AppointmentSchedulingService $scheduler) {}

    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('No user found — skipping AppointmentSeeder.');
            return;
        }

        $contacts = Contacts::where('created_by', $user->id)->get();

        if ($contacts->isEmpty()) {
            $this->command->warn('No contacts found — run ContactSeeder first.');
            return;
        }

        $slots = [
            ['date' => now()->addDays(3)->format('Y-m-d'),  'time' => '09:30:00', 'address' => 'EC2A1NT'],
            ['date' => now()->addDays(5)->format('Y-m-d'),  'time' => '11:00:00', 'address' => 'W1F7LP'],
            ['date' => now()->addDays(7)->format('Y-m-d'),  'time' => '14:00:00', 'address' => 'SW3 4RY'],
            ['date' => now()->addDays(10)->format('Y-m-d'), 'time' => '10:30:00', 'address' => 'E14 5AB'],
            ['date' => now()->addDays(14)->format('Y-m-d'), 'time' => '15:00:00', 'address' => 'N1 9GU'],
            ['date' => now()->addDays(18)->format('Y-m-d'), 'time' => '09:00:00', 'address' => 'SE1 7PB'],
            ['date' => now()->addDays(21)->format('Y-m-d'), 'time' => '13:30:00', 'address' => 'WC2N5DU'],
            ['date' => now()->addDays(25)->format('Y-m-d'), 'time' => '16:00:00', 'address' => 'EC4M5UT'],
            ['date' => now()->addDays(28)->format('Y-m-d'), 'time' => '11:30:00', 'address' => 'W8 4PT'],
            ['date' => now()->addDays(32)->format('Y-m-d'), 'time' => '14:30:00', 'address' => 'SW7 2AZ'],
        ];

        $created = 0;
        foreach ($slots as $i => $slot) {
            $contact = $contacts[$i % $contacts->count()];
            $address = str_replace(' ', '', $slot['address']);

            $travel   = $this->scheduler->estimateTravel($user->address, $address);
            $schedule = $this->scheduler->buildSchedule($slot['time'], $travel['duration_to_site'], $travel['duration_to_office']);

            $appt = Appointments::firstOrCreate(
                [
                    'user_id'              => $user->id,
                    'contact_id'           => $contact->id,
                    'appointment_date'     => $slot['date'],
                    'appointment_start_time' => $slot['time'],
                ],
                [
                    'appointment_address'         => $address,
                    'measured_distance'           => $travel['distance'],
                    'departure_time_to_site_office' => $schedule['departure_time_to_site_office'],
                    'appointment_end_time'          => $schedule['appointment_end_time'],
                    'arrival_time_to_agent_office'  => $schedule['arrival_time_to_agent_office'],
                ]
            );

            if ($appt->wasRecentlyCreated) {
                $created++;
            }
        }

        $total = Appointments::where('user_id', $user->id)->count();
        $this->command->info("Appointments seeded — {$created} new, {$total} total for user [{$user->email}].");
    }
}
