<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $coaches = DB::table('users')->where('role', 'coach')->pluck('id');

        // $coaches = DB::table('users')->whereHas(
        //     'role',
        //     function ($query) {
        //         $query->where('name', 'coach')->pluck('id');

        $coaches = User::whereHas(
            'role',
            function ($query) {
                $query->where('name', 'coach');
            }
        )->pluck('id');

        $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($coaches as $coach_id) {
            $availabilities = [
                [
                    'day_of_week' => $days_of_week[array_rand($days_of_week)],
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    // 'start_time' => '09:00',
                    // 'end_time' => '12:00',
                ],
                [
                    'day_of_week' => $days_of_week[array_rand($days_of_week)],
                    'start_time' => '14:00:00',
                    'end_time' => '17:00:00',
                    // 'start_time' => '14:00',
                    // 'end_time' => '17:00',
                ],
            ];

            foreach ($availabilities as $availability) {
                DB::table('availabilities')->insert([
                    'coach_id' => $coach_id,
                    'day_of_week' => $availability['day_of_week'],
                    'start_time' => $availability['start_time'],
                    'end_time' => $availability['end_time'],
                ]);
            }
        }
    }
}
