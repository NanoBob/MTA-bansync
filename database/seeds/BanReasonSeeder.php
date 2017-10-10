<?php

use Illuminate\Database\Seeder;

class BanReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ban_reasons')->insert([
            'reason' => 'Cheating / hacking',
        ]);
        DB::table('ban_reasons')->insert([
            'reason' => 'Bug abuse',
        ]);
        DB::table('ban_reasons')->insert([
            'reason' => 'Unwanted advertising',
        ]);
        DB::table('ban_reasons')->insert([
            'reason' => 'Abusive behaviour',
        ]);
        DB::table('ban_reasons')->insert([
            'reason' => 'Ban evasion',
        ]);
        DB::table('ban_reasons')->insert([
            'reason' => 'General rule breaking',
        ]);
    }
}
