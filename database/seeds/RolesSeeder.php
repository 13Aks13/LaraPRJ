<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'title' => 'role_admin',
        ]);
        DB::table('roles')->insert([
            'title' => 'role_user',
        ]);
    }
}
