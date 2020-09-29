<?php

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 26,
                'migration' => '2020_02_23_184322_create_new_numbers_table',
                'batch' => 13,
            ),
            1 => 
            array (
                'id' => 28,
                'migration' => '2020_02_24_144357_create_assigned_table',
                'batch' => 13,
            ),
            2 => 
            array (
                'id' => 29,
                'migration' => '2020_02_24_165039_create_contacted_table',
                'batch' => 13,
            ),
            3 => 
            array (
                'id' => 31,
                'migration' => '2020_02_25_115151_create_registered_table',
                'batch' => 13,
            ),
            4 => 
            array (
                'id' => 32,
                'migration' => '2020_02_25_115354_create_check_table',
                'batch' => 13,
            ),
            5 => 
            array (
                'id' => 33,
                'migration' => '2020_02_25_115547_create_reassign_table',
                'batch' => 13,
            ),
            6 => 
            array (
                'id' => 34,
                'migration' => '2020_02_25_115858_create_trash_table',
                'batch' => 13,
            ),
            7 => 
            array (
                'id' => 35,
                'migration' => '2020_02_25_141102_create_players_table',
                'batch' => 13,
            ),
            8 => 
            array (
                'id' => 49,
                'migration' => '2020_02_27_193956_create_interested_table',
                'batch' => 18,
            ),
            9 => 
            array (
                'id' => 53,
                'migration' => '2020_02_23_202951_create_index_master_numbers_table',
                'batch' => 21,
            ),
            10 => 
            array (
                'id' => 62,
                'migration' => '2020_03_04_123644_create_campaign_result_table',
                'batch' => 23,
            ),
            11 => 
            array (
                'id' => 64,
                'migration' => '2020_03_04_123644_create_category_web_table',
                'batch' => 23,
            ),
            12 => 
            array (
                'id' => 65,
                'migration' => '2020_03_04_123644_create_connect_response_table',
                'batch' => 23,
            ),
            13 => 
            array (
                'id' => 66,
                'migration' => '2020_03_04_123644_create_constant_yesno_table',
                'batch' => 23,
            ),
            14 => 
            array (
                'id' => 67,
                'migration' => '2020_03_04_123644_create_next_action_table',
                'batch' => 23,
            ),
            15 => 
            array (
                'id' => 68,
                'migration' => '2020_03_04_123644_create_category_game_table',
                'batch' => 24,
            ),
            16 => 
            array (
                'id' => 69,
                'migration' => '2020_03_04_225905_create_settings_table',
                'batch' => 25,
            ),
            17 => 
            array (
                'id' => 70,
                'migration' => '2020_03_05_191641_alter_items_to_master_numbers',
                'batch' => 26,
            ),
            18 => 
            array (
                'id' => 71,
                'migration' => '2020_03_20_214046_create_users_table',
                'batch' => 29,
            ),
            19 => 
            array (
                'id' => 72,
                'migration' => '2020_03_18_022011_add_deleted_at_to_users_table',
                'batch' => 28,
            ),
            20 => 
            array (
                'id' => 73,
                'migration' => '2020_03_20_214046_create_icons_table',
                'batch' => 29,
            ),
            21 => 
            array (
                'id' => 74,
                'migration' => '2020_03_20_214046_create_model_has_permissions_table',
                'batch' => 29,
            ),
            22 => 
            array (
                'id' => 75,
                'migration' => '2020_03_20_214046_create_model_has_roles_table',
                'batch' => 29,
            ),
            23 => 
            array (
                'id' => 76,
                'migration' => '2020_03_20_214046_create_permissions_table',
                'batch' => 29,
            ),
            24 => 
            array (
                'id' => 77,
                'migration' => '2020_03_20_214046_create_roles_table',
                'batch' => 29,
            ),
            25 => 
            array (
                'id' => 78,
                'migration' => '2020_03_20_214046_create_role_has_permissions_table',
                'batch' => 29,
            ),
            26 => 
            array (
                'id' => 80,
                'migration' => '2020_03_20_214047_add_foreign_keys_to_model_has_permissions_table',
                'batch' => 29,
            ),
            27 => 
            array (
                'id' => 81,
                'migration' => '2020_03_20_214047_add_foreign_keys_to_model_has_roles_table',
                'batch' => 29,
            ),
            28 => 
            array (
                'id' => 82,
                'migration' => '2020_03_20_214047_add_foreign_keys_to_role_has_permissions_table',
                'batch' => 29,
            ),
        ));
        
        
    }
}