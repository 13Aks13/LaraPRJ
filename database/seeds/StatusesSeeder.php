<?php

use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'title' => 'new',
            'color' => 'red',
        ]);

        DB::table('statuses')->insert([
            'title' => 'in progress',
            'color' => 'blue',
        ]);

        DB::table('statuses')->insert([
            'title' => 'done',
            'color' => 'green',
        ]);
    }
}
