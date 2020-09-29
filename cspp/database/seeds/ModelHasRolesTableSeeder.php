<?php

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 1,
            ),
            1 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 39,
            ),
            2 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 40,
            ),
            3 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 59,
            ),
            4 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 79,
            ),
            5 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 83,
            ),
            6 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 84,
            ),
            7 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 135,
            ),
            8 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 3,
            ),
            9 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 19,
            ),
            10 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 44,
            ),
            11 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 58,
            ),
            12 => 
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 61,
            ),
            13 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 2,
            ),
            14 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 29,
            ),
            15 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 32,
            ),
            16 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 33,
            ),
            17 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 46,
            ),
            18 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 47,
            ),
            19 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 56,
            ),
            20 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 60,
            ),
            21 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 62,
            ),
            22 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 63,
            ),
            23 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 64,
            ),
            24 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 66,
            ),
            25 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 67,
            ),
            26 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 68,
            ),
            27 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 69,
            ),
            28 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 71,
            ),
            29 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 72,
            ),
            30 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 75,
            ),
            31 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 77,
            ),
            32 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 80,
            ),
            33 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 81,
            ),
            34 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 82,
            ),
            35 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 133,
            ),
            36 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\BackpackUser',
                'model_id' => 134,
            ),
        ));
        
        
    }
}