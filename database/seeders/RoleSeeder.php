<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Coach',
            'Client',
        ];

        // Seed the games into the database
        foreach ($names as $name) {
            DB::table('roles')->insert([
                'name' => $name,
            ]);
        }
    }
}
