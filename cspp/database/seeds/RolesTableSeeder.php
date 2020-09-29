<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'manager',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 09:46:21',
                'updated_at' => '2020-03-20 03:07:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'supervisor',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 09:46:21',
                'updated_at' => '2020-03-20 03:07:26',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'user',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 09:46:21',
                'updated_at' => '2020-03-20 03:07:36',
            ),
        ));
        
        
    }
}