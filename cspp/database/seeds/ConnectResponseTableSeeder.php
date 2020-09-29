<?php

use Illuminate\Database\Seeder;

class ConnectResponseTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('connect_response')->delete();
        
        \DB::table('connect_response')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Active Call',
                'description' => 'Pembicaraan aktif dengan pelanggan',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Blocked',
                'description' => 'Orangnya memblokir nomor telp perusahaan',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Line Busy',
                'description' => 'Jaringan sedang sibuk, orangnya lagi online telepon',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Mailbox',
                'description' => 'Hpnya di forward ke mailbox atau sedang tidak ada jaringan',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Tidak Diangkat',
                'description' => 'Telepon nyambung tapi belum di angkat',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Tidak Terdaftar',
                'description' => 'Nomor sudah hangus',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Tidak Aktif',
            'description' => 'Hpnya mati karena tidak ada battery (low batt)',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Rejected',
                'description' => 'Orangnya menolak untuk angkat telepon',
                'created_at' => '2020-03-04 11:00:04',
                'updated_at' => '2020-03-04 11:00:04',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}