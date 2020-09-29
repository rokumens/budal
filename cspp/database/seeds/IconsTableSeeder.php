<?php

use Illuminate\Database\Seeder;

class IconsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('icons')->delete();
        
        \DB::table('icons')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Tao',
                'icon' => 'fa-fas fa-adjust',
                'created_at' => '2020-03-14 09:46:20',
                'updated_at' => '2020-03-14 09:46:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Archive',
                'icon' => 'fa-fas fa-archive',
                'created_at' => '2020-03-14 09:46:20',
                'updated_at' => '2020-03-14 09:46:20',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Right',
                'icon' => 'fa-fas fa-angle-right',
                'created_at' => '2020-03-14 09:46:20',
                'updated_at' => '2020-03-14 09:46:20',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Home page',
                'icon' => 'fa-fas fa-home',
                'created_at' => '2020-03-14 09:46:20',
                'updated_at' => '2020-03-14 09:46:20',
            ),
        ));
        
        
    }
}