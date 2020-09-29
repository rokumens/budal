<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'first_name' => 'Jazz',
                'last_name' => 'Plunker',
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$pEIm2quZKSLqwVbrdRTSGeRoABQCtgp1I9u5/b4eue1n8vRhKQ2RO',
                'remember_token' => 'Y7qfBqXrgYxDkF24mBN5pcHMHxk6gy8wnUACnqjTzTnXiV10gVHSDW5aUMlp',
                'activated' => 1,
                'token' => 'G766GZHwPP9m86QyaHOMjllMLNuGB29ICj0xO9NlLbJ8B3C09Bzf8NwwQ3es4MfG',
                'signup_ip_address' => NULL,
                'signup_confirmation_ip_address' => '29.172.228.201',
                'signup_sm_ip_address' => NULL,
                'admin_ip_address' => '115.13.247.209',
                'updated_ip_address' => '192.168.10.1',
                'deleted_ip_address' => NULL,
                'created_at' => '2020-04-08 05:01:49',
                'updated_at' => '2020-04-16 13:15:23',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'jmayer',
                'first_name' => 'Garrison',
                'last_name' => 'Turcotte',
                'email' => 'user@user.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$v8M.T0sfiYyhH8LRc9IPdekigpWL2mfV4GK/m68qSZ9BF6jUMLiF2',
                'remember_token' => NULL,
                'activated' => 1,
                'token' => 'ScYDIf4zBfFyBpO1S1NAtHbdbEu0K47c4K9qcjqSSMlD9DhamSSoNXECwVCp21MP',
                'signup_ip_address' => '241.102.255.18',
                'signup_confirmation_ip_address' => '244.81.34.117',
                'signup_sm_ip_address' => NULL,
                'admin_ip_address' => NULL,
                'updated_ip_address' => NULL,
                'deleted_ip_address' => NULL,
                'created_at' => '2020-04-08 05:01:49',
                'updated_at' => '2020-04-08 05:01:49',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}