<?php

use Illuminate\Database\Seeder;

class OrchardpoolsSocialsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orchardpools_socials')->delete();
        
        \DB::table('orchardpools_socials')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Facebook',
                'url' => '#',
                'icon' => 'fa fa-facebook',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Twitter',
                'url' => '#',
                'icon' => 'fa fa-twitter',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Google Plus',
                'url' => '#',
                'icon' => 'fa fa-google-plus',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Instagram',
                'url' => '#',
                'icon' => 'fa fa-instagram',
            ),
        ));
        
        
    }
}