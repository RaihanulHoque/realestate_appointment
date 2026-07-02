<?php

namespace Database\Seeders;

use App\Models\Contacts;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('No user found — skipping ContactSeeder. Register a user first.');
            return;
        }

        $contacts = [
            ['name' => 'James',    'surname' => 'Hartley',   'email' => 'james.hartley@example.com',   'phone' => '07911100001', 'address' => 'EC1A1BB'],
            ['name' => 'Sophie',   'surname' => 'Williams',  'email' => 'sophie.williams@example.com',  'phone' => '07922200002', 'address' => 'W1A1AA'],
            ['name' => 'Oliver',   'surname' => 'Bennett',   'email' => 'oliver.bennett@example.com',   'phone' => '07933300003', 'address' => 'SW1A2AA'],
            ['name' => 'Emily',    'surname' => 'Clarke',    'email' => 'emily.clarke@example.com',     'phone' => '07944400004', 'address' => 'E1W1AA'],
            ['name' => 'Muhammad', 'surname' => 'Khan',      'email' => 'muhammad.khan@example.com',    'phone' => '07955500005', 'address' => 'LS11AB'],
            ['name' => 'Charlotte','surname' => 'Edwards',   'email' => 'charlotte.edwards@example.com','phone' => '07966600006', 'address' => 'M11AE'],
            ['name' => 'Harry',    'surname' => 'Thompson',  'email' => 'harry.thompson@example.com',   'phone' => '07977700007', 'address' => 'B11BB'],
            ['name' => 'Amelia',   'surname' => 'Robinson',  'email' => 'amelia.robinson@example.com',  'phone' => '07988800008', 'address' => 'G11AA'],
            ['name' => 'George',   'surname' => 'Walker',    'email' => 'george.walker@example.com',    'phone' => '07999900009', 'address' => 'EH11YZ'],
            ['name' => 'Isabella', 'surname' => 'Mitchell',  'email' => 'isabella.mitchell@example.com','phone' => '07811100010', 'address' => 'CF101AA'],
            ['name' => 'Noah',     'surname' => 'Scott',     'email' => 'noah.scott@example.com',       'phone' => '07822200011', 'address' => 'NE11DF'],
            ['name' => 'Mia',      'surname' => 'Adams',     'email' => 'mia.adams@example.com',        'phone' => '07833300012', 'address' => 'BS11TR'],
        ];

        foreach ($contacts as $data) {
            Contacts::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['created_by' => $user->id])
            );
        }

        $count = Contacts::where('created_by', $user->id)->count();
        $this->command->info("Contacts seeded — {$count} total for user [{$user->email}].");
    }
}
