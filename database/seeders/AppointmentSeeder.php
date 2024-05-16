<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coaches = User::whereHas(
            'role',
            function ($query) {
                $query->where('name', 'coach');
            }
        )->pluck('id');

        $clients = User::whereHas(
            'role',
            function ($query) {
                $query->where('name', 'client');
            }
        )->pluck('id');

        foreach ($coaches as $coach_id) {
            $availabilities = DB::table('availabilities')->where('coach_id', $coach_id)->get();

            foreach ($availabilities as $availability) {
                // Generate a random number between 0 and 1
                $randomNumber = mt_rand() / mt_getrandmax();

                // If the random number is less than 0.5, create an appointment
                if ($randomNumber < 0.5) {
                    DB::table('appointments')->insert([
                        'client_id' => $clients->random(),
                        'coach_id' => $coach_id,
                        'date' => Carbon::parse($availability->day_of_week)->format('Y-m-d'),
                        'start' => $availability->start_time, // Changed 'hours' to 'start'
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }

    /**
     * Generate appointment hours between start time and end time.
     */
    // private function generateAppointmentHours(string $start_time, string $end_time): array
    // {
    //     $start_time = Carbon::createFromFormat('H:i:s', $start_time);
    //     $end_time = Carbon::createFromFormat('H:i:s', $end_time);

    //     $appointment_hours = [];

    //     while ($start_time->lessThan($end_time)) {
    //         $appointment_hours[] = $start_time->format('H:i:s');
    //         $start_time->addHour(); // assumes that each appointment lasts one hour. If appointments have a different duration, you should modify the addHour() method accordingly. For example, for 30-minute appointments, you could use addMinutes(30).
    //     }

    //     return $appointment_hours;
    // }
}
