<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permission_role')->delete();
        
        \DB::table('permission_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'permission_id' => 1,
                'role_id' => 1,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'permission_id' => 2,
                'role_id' => 1,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'permission_id' => 3,
                'role_id' => 1,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'permission_id' => 4,
                'role_id' => 1,
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}