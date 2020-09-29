<?php

use Illuminate\Database\Seeder;

class CategoryGameTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_game')->delete();
        
        \DB::table('category_game')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sportsbook',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Live Casino',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Casino Games',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Tembak Ikan',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Togel',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Poker/P2P',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Slots',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Whitelabel Umum',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Ikan Kuning',
                'created_at' => '2020-03-04 11:35:57',
                'updated_at' => '2020-03-04 11:35:57',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}