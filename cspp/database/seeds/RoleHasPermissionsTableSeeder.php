<?php

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_has_permissions')->delete();
        
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 4,
                'role_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 5,
                'role_id' => 1,
            ),
            2 => 
            array (
                'permission_id' => 6,
                'role_id' => 1,
            ),
            3 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            4 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            5 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            6 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            7 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            8 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            9 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            10 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            11 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            12 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
            ),
            13 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            14 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
            ),
            15 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            16 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
            ),
            17 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            18 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
            ),
            19 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
            ),
            20 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            21 => 
            array (
                'permission_id' => 19,
                'role_id' => 2,
            ),
            22 => 
            array (
                'permission_id' => 19,
                'role_id' => 3,
            ),
            23 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            24 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
            ),
            25 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
            ),
            26 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            27 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
            ),
            28 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
            ),
            29 => 
            array (
                'permission_id' => 22,
                'role_id' => 1,
            ),
            30 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
            ),
            31 => 
            array (
                'permission_id' => 23,
                'role_id' => 1,
            ),
            32 => 
            array (
                'permission_id' => 23,
                'role_id' => 2,
            ),
            33 => 
            array (
                'permission_id' => 23,
                'role_id' => 3,
            ),
            34 => 
            array (
                'permission_id' => 24,
                'role_id' => 1,
            ),
            35 => 
            array (
                'permission_id' => 24,
                'role_id' => 2,
            ),
            36 => 
            array (
                'permission_id' => 24,
                'role_id' => 3,
            ),
            37 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
            ),
            38 => 
            array (
                'permission_id' => 25,
                'role_id' => 2,
            ),
            39 => 
            array (
                'permission_id' => 26,
                'role_id' => 1,
            ),
            40 => 
            array (
                'permission_id' => 26,
                'role_id' => 2,
            ),
            41 => 
            array (
                'permission_id' => 27,
                'role_id' => 1,
            ),
            42 => 
            array (
                'permission_id' => 27,
                'role_id' => 2,
            ),
            43 => 
            array (
                'permission_id' => 27,
                'role_id' => 3,
            ),
            44 => 
            array (
                'permission_id' => 28,
                'role_id' => 1,
            ),
            45 => 
            array (
                'permission_id' => 28,
                'role_id' => 2,
            ),
            46 => 
            array (
                'permission_id' => 29,
                'role_id' => 1,
            ),
            47 => 
            array (
                'permission_id' => 29,
                'role_id' => 2,
            ),
            48 => 
            array (
                'permission_id' => 30,
                'role_id' => 1,
            ),
            49 => 
            array (
                'permission_id' => 30,
                'role_id' => 2,
            ),
            50 => 
            array (
                'permission_id' => 30,
                'role_id' => 3,
            ),
            51 => 
            array (
                'permission_id' => 31,
                'role_id' => 1,
            ),
            52 => 
            array (
                'permission_id' => 31,
                'role_id' => 2,
            ),
            53 => 
            array (
                'permission_id' => 31,
                'role_id' => 3,
            ),
            54 => 
            array (
                'permission_id' => 32,
                'role_id' => 1,
            ),
            55 => 
            array (
                'permission_id' => 32,
                'role_id' => 2,
            ),
            56 => 
            array (
                'permission_id' => 32,
                'role_id' => 3,
            ),
            57 => 
            array (
                'permission_id' => 33,
                'role_id' => 1,
            ),
            58 => 
            array (
                'permission_id' => 33,
                'role_id' => 2,
            ),
            59 => 
            array (
                'permission_id' => 34,
                'role_id' => 1,
            ),
            60 => 
            array (
                'permission_id' => 34,
                'role_id' => 2,
            ),
            61 => 
            array (
                'permission_id' => 34,
                'role_id' => 3,
            ),
            62 => 
            array (
                'permission_id' => 35,
                'role_id' => 1,
            ),
            63 => 
            array (
                'permission_id' => 35,
                'role_id' => 2,
            ),
            64 => 
            array (
                'permission_id' => 36,
                'role_id' => 1,
            ),
            65 => 
            array (
                'permission_id' => 36,
                'role_id' => 2,
            ),
            66 => 
            array (
                'permission_id' => 37,
                'role_id' => 1,
            ),
            67 => 
            array (
                'permission_id' => 37,
                'role_id' => 2,
            ),
            68 => 
            array (
                'permission_id' => 38,
                'role_id' => 1,
            ),
            69 => 
            array (
                'permission_id' => 38,
                'role_id' => 2,
            ),
            70 => 
            array (
                'permission_id' => 39,
                'role_id' => 1,
            ),
            71 => 
            array (
                'permission_id' => 39,
                'role_id' => 2,
            ),
            72 => 
            array (
                'permission_id' => 40,
                'role_id' => 1,
            ),
            73 => 
            array (
                'permission_id' => 40,
                'role_id' => 2,
            ),
            74 => 
            array (
                'permission_id' => 41,
                'role_id' => 1,
            ),
            75 => 
            array (
                'permission_id' => 41,
                'role_id' => 2,
            ),
            76 => 
            array (
                'permission_id' => 42,
                'role_id' => 1,
            ),
            77 => 
            array (
                'permission_id' => 42,
                'role_id' => 2,
            ),
            78 => 
            array (
                'permission_id' => 43,
                'role_id' => 1,
            ),
            79 => 
            array (
                'permission_id' => 43,
                'role_id' => 2,
            ),
            80 => 
            array (
                'permission_id' => 44,
                'role_id' => 1,
            ),
            81 => 
            array (
                'permission_id' => 44,
                'role_id' => 2,
            ),
            82 => 
            array (
                'permission_id' => 45,
                'role_id' => 1,
            ),
            83 => 
            array (
                'permission_id' => 46,
                'role_id' => 1,
            ),
            84 => 
            array (
                'permission_id' => 46,
                'role_id' => 2,
            ),
            85 => 
            array (
                'permission_id' => 47,
                'role_id' => 1,
            ),
            86 => 
            array (
                'permission_id' => 47,
                'role_id' => 2,
            ),
            87 => 
            array (
                'permission_id' => 47,
                'role_id' => 3,
            ),
            88 => 
            array (
                'permission_id' => 48,
                'role_id' => 1,
            ),
            89 => 
            array (
                'permission_id' => 48,
                'role_id' => 2,
            ),
            90 => 
            array (
                'permission_id' => 48,
                'role_id' => 3,
            ),
            91 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
            ),
            92 => 
            array (
                'permission_id' => 50,
                'role_id' => 2,
            ),
            93 => 
            array (
                'permission_id' => 51,
                'role_id' => 2,
            ),
        ));
        
        
    }
}