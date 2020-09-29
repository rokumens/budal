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
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Admin Role',
                'level' => 5,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'User',
                'slug' => 'user',
                'description' => 'User Role',
                'level' => 1,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Unverified',
                'slug' => 'unverified',
                'description' => 'Unverified Role',
                'level' => 0,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}