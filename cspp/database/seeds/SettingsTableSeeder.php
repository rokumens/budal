<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'contacted_times' => 1,
                'assigned_times_previous' => 1,
                'assigned_times_now' => 1,
                'assigned_times_max' => 1,
                'created_at' => '2020-03-02 00:00:00',
                'updated_at' => '2020-03-04 12:54:13',
            ),
        ));
        
        
    }
}