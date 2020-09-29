<?php

use Illuminate\Database\Seeder;

class ConstantYesnoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('constant_yesno')->delete();
        
        \DB::table('constant_yesno')->insert(array (
            0 => 
            array (
                'id' => 1,
                'value' => 1,
                'name' => 'Yes',
                'created_at' => '2020-03-04 10:01:57',
                'updated_at' => '2020-03-04 10:01:57',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'value' => 0,
                'name' => 'No',
                'created_at' => '2020-03-04 10:01:57',
                'updated_at' => '2020-03-04 10:01:57',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}