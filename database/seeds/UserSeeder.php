<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'nanobob',
            'email' => 'bans@nanobob.net',
            'password' => bcrypt('secret'),

            'type' => 'server',
            'verified' => 1,
            'api_key' => str_random(64)
        ]);
    }
}
