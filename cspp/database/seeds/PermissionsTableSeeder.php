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
                'id' => 4,
                'name' => 'manage-users',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 09:46:21',
                'updated_at' => '2020-03-18 12:24:46',
            ),
            1 => 
            array (
                'id' => 5,
                'name' => 'manage-roles',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 09:46:21',
                'updated_at' => '2020-03-18 12:24:35',
            ),
            2 => 
            array (
                'id' => 6,
                'name' => 'manage-permissions',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 09:46:21',
                'updated_at' => '2020-03-18 12:24:22',
            ),
            3 => 
            array (
                'id' => 10,
                'name' => 'menu-upload',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 10:43:09',
                'updated_at' => '2020-03-18 07:41:59',
            ),
            4 => 
            array (
                'id' => 12,
                'name' => 'menu-newnumbers',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-14 12:51:49',
                'updated_at' => '2020-03-18 05:57:47',
            ),
            5 => 
            array (
                'id' => 13,
                'name' => 'list-interested-own',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-17 10:47:33',
                'updated_at' => '2020-03-18 07:10:46',
            ),
            6 => 
            array (
                'id' => 14,
                'name' => 'change-cs-assigned',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-17 10:48:16',
                'updated_at' => '2020-03-17 10:48:16',
            ),
            7 => 
            array (
                'id' => 15,
                'name' => 'menu-check',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 03:50:06',
                'updated_at' => '2020-03-18 07:46:33',
            ),
            8 => 
            array (
                'id' => 16,
                'name' => 'menu-reassign',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 03:50:18',
                'updated_at' => '2020-03-18 07:46:12',
            ),
            9 => 
            array (
                'id' => 17,
                'name' => 'view-assigned',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 04:13:24',
                'updated_at' => '2020-03-18 04:13:24',
            ),
            10 => 
            array (
                'id' => 18,
                'name' => 'edit-assigned',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 04:35:26',
                'updated_at' => '2020-03-18 06:02:30',
            ),
            11 => 
            array (
                'id' => 19,
                'name' => 'menu-assigned',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 04:37:34',
                'updated_at' => '2020-03-18 05:58:12',
            ),
            12 => 
            array (
                'id' => 20,
                'name' => 'list-assigned-own',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 05:18:10',
                'updated_at' => '2020-03-18 07:10:17',
            ),
            13 => 
            array (
                'id' => 21,
                'name' => 'menu-contacted',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 05:28:48',
                'updated_at' => '2020-03-18 05:52:31',
            ),
            14 => 
            array (
                'id' => 22,
                'name' => 'view-contacted',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 06:03:46',
                'updated_at' => '2020-03-18 06:03:46',
            ),
            15 => 
            array (
                'id' => 23,
                'name' => 'edit-contacted',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 06:04:09',
                'updated_at' => '2020-03-18 06:06:13',
            ),
            16 => 
            array (
                'id' => 24,
                'name' => 'menu-interested',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 06:19:15',
                'updated_at' => '2020-03-18 06:19:15',
            ),
            17 => 
            array (
                'id' => 25,
                'name' => 'change-cs-contacted',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 06:42:32',
                'updated_at' => '2020-03-18 06:42:32',
            ),
            18 => 
            array (
                'id' => 26,
                'name' => 'view-interested',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 06:59:19',
                'updated_at' => '2020-03-18 06:59:19',
            ),
            19 => 
            array (
                'id' => 27,
                'name' => 'edit-interested',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 06:59:27',
                'updated_at' => '2020-03-18 06:59:27',
            ),
            20 => 
            array (
                'id' => 28,
                'name' => 'change-cs-interested',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:05:56',
                'updated_at' => '2020-03-18 07:05:56',
            ),
            21 => 
            array (
                'id' => 29,
                'name' => 'list-interested-all',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:09:55',
                'updated_at' => '2020-03-21 16:40:15',
            ),
            22 => 
            array (
                'id' => 30,
                'name' => 'list-contacted-own',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:12:06',
                'updated_at' => '2020-03-18 07:12:06',
            ),
            23 => 
            array (
                'id' => 31,
                'name' => 'menu-registered',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:19:51',
                'updated_at' => '2020-03-18 07:19:51',
            ),
            24 => 
            array (
                'id' => 32,
                'name' => 'list-registered-own',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:35:31',
                'updated_at' => '2020-03-18 07:35:31',
            ),
            25 => 
            array (
                'id' => 33,
                'name' => 'view-registered',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:36:01',
                'updated_at' => '2020-03-18 07:36:01',
            ),
            26 => 
            array (
                'id' => 34,
                'name' => 'edit-registered',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:36:10',
                'updated_at' => '2020-03-18 07:36:10',
            ),
            27 => 
            array (
                'id' => 35,
                'name' => 'change-cs-registered',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 07:38:10',
                'updated_at' => '2020-03-18 07:38:10',
            ),
            28 => 
            array (
                'id' => 36,
                'name' => 'view-check',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:05:59',
                'updated_at' => '2020-03-18 08:05:59',
            ),
            29 => 
            array (
                'id' => 37,
                'name' => 'edit-check',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:06:10',
                'updated_at' => '2020-03-18 08:06:10',
            ),
            30 => 
            array (
                'id' => 38,
                'name' => 'change-cs-check',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:06:19',
                'updated_at' => '2020-03-18 08:06:19',
            ),
            31 => 
            array (
                'id' => 39,
                'name' => 'assign-cs',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:32:43',
                'updated_at' => '2020-03-18 08:32:43',
            ),
            32 => 
            array (
                'id' => 40,
                'name' => 'reassign-cs',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:32:51',
                'updated_at' => '2020-03-18 08:32:51',
            ),
            33 => 
            array (
                'id' => 41,
                'name' => 'view-reassign',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:33:01',
                'updated_at' => '2020-03-18 08:33:01',
            ),
            34 => 
            array (
                'id' => 42,
                'name' => 'menu-players',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:41:18',
                'updated_at' => '2020-03-18 08:41:18',
            ),
            35 => 
            array (
                'id' => 43,
                'name' => 'menu-trash',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 08:45:07',
                'updated_at' => '2020-03-18 08:45:07',
            ),
            36 => 
            array (
                'id' => 44,
                'name' => 'dashboard-all',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 11:37:04',
                'updated_at' => '2020-03-18 11:37:04',
            ),
            37 => 
            array (
                'id' => 45,
                'name' => 'menu-settings',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 12:55:59',
                'updated_at' => '2020-03-18 18:24:42',
            ),
            38 => 
            array (
                'id' => 46,
                'name' => 'demo-leader',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 18:51:37',
                'updated_at' => '2020-03-18 18:51:37',
            ),
            39 => 
            array (
                'id' => 47,
                'name' => 'demo-cs',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-18 18:51:42',
                'updated_at' => '2020-03-20 15:53:12',
            ),
            40 => 
            array (
                'id' => 48,
                'name' => 'menu-profile',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-21 04:34:18',
                'updated_at' => '2020-03-21 04:34:18',
            ),
            41 => 
            array (
                'id' => 49,
                'name' => 'list-assigned-all',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-21 16:38:22',
                'updated_at' => '2020-03-21 16:38:22',
            ),
            42 => 
            array (
                'id' => 50,
                'name' => 'ist-contacted-all',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-21 16:38:38',
                'updated_at' => '2020-03-21 16:38:38',
            ),
            43 => 
            array (
                'id' => 51,
                'name' => 'list-registered-all',
                'guard_name' => 'backpack',
                'created_at' => '2020-03-21 16:41:14',
                'updated_at' => '2020-03-21 16:41:14',
            ),
        ));
        
        
    }
}