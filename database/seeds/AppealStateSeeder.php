<?php

use Illuminate\Database\Seeder;

class AppealStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appeal_states')->insert([
            [
            'state' => 'Open',
            ],
            [
            'state' => 'Accepted',
            ],
            [
                'state' => 'Denied',
            ],
            [
                'state' => 'Permanently denied',
            ],
        ]);
    }
}
