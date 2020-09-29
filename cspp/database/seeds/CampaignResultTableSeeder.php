<?php

use Illuminate\Database\Seeder;

class CampaignResultTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('campaign_result')->delete();
        
        \DB::table('campaign_result')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'Interest (Player)',
                'created_at' => '2020-03-04 12:17:04',
                'updated_at' => '2020-03-04 12:17:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'Not Interest (Bukan Player)',
                'created_at' => '2020-03-04 12:17:04',
                'updated_at' => '2020-03-04 12:17:04',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'Unknown (Tidak Diketahui)',
                'created_at' => '2020-03-04 12:17:04',
                'updated_at' => '2020-03-04 12:17:04',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}