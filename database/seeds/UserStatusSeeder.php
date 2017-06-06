<?php

use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
            'name' => 'Offline',
            'color' => '#FFF'
        ]);

        DB::table('user_statuses')->insert([
            'name' => 'Check In',
            'color' => '#FFF'
        ]);

        DB::table('user_statuses')->insert([
            'name' => 'Lunch',
            'color' => '#FFF'
        ]);

        DB::table('user_statuses')->insert([
            'name' => 'Break',
            'color' => '#FFF'
        ]);

        DB::table('user_statuses')->insert([
            'name' => 'Call',
            'color' => '#FFF'
        ]);

    }

}