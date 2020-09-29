<?php

use Illuminate\Database\Seeder;

class CategoryWebTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_web')->delete();
        
        \DB::table('category_web')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Web Agent',
                'created_at' => '2020-03-04 11:38:59',
                'updated_at' => '2020-03-04 11:38:59',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Whitelabel Umum',
                'created_at' => '2020-03-04 11:38:59',
                'updated_at' => '2020-03-04 11:38:59',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Whitelabel P2P',
                'created_at' => '2020-03-04 11:38:59',
                'updated_at' => '2020-03-04 11:38:59',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Web Togel',
                'created_at' => '2020-03-04 11:38:59',
                'updated_at' => '2020-03-04 11:38:59',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Web Tembak Ikan',
                'created_at' => '2020-03-04 11:38:59',
                'updated_at' => '2020-03-04 11:38:59',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Web Slots',
                'created_at' => '2020-03-04 11:38:59',
                'updated_at' => '2020-03-04 11:38:59',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}