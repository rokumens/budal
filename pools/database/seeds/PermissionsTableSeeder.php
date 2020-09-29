<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Can View Users',
                'slug' => 'view.users',
                'description' => 'Can view users',
                'model' => 'Permission',
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Can Create Users',
                'slug' => 'create.users',
                'description' => 'Can create new users',
                'model' => 'Permission',
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Can Edit Users',
                'slug' => 'edit.users',
                'description' => 'Can edit users',
                'model' => 'Permission',
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Can Delete Users',
                'slug' => 'delete.users',
                'description' => 'Can delete users',
                'model' => 'Permission',
                'created_at' => '2020-04-08 05:01:48',
                'updated_at' => '2020-04-08 05:01:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}