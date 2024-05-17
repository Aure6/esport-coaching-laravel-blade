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
                // Convert start_time and end_time to Carbon instances
                $start = Carbon::createFromFormat('H:i:s', $availability->start_time);
                $end = Carbon::createFromFormat('H:i:s', $availability->end_time);

                // Generate one-hour slots between start_time and end_time
                for ($time = $start; $time->lessThan($end); $time->addHour()) {
                    // Generate a random number between 0 and 1
                    $randomNumber = mt_rand() / mt_getrandmax();

                    // If the random number is less than 0.5, create an appointment
                    if ($randomNumber < 0.5) {
                        DB::table('appointments')->insert([
                            'client_id' => $clients->random(),
                            'coach_id' => $coach_id,
                            'date' => Carbon::parse($availability->day_of_week)->format('Y-m-d'),
                            'start' => $time->format('H:i:s'), // Use the current time slot
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
    }
}
