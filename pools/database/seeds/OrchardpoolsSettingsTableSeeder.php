<?php

use Illuminate\Database\Seeder;

class OrchardpoolsSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orchardpools_settings')->delete();
        
        \DB::table('orchardpools_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'timezone' => 'Asia/Jakarta',
                'countdown_stop' => '18:49:00',
                'min_count_reload_time' => 1,
                'max_count_reload_time' => 2,
                'time_show_max' => NULL,
                'logo' => '1587736364.png',
                'logo_height' => NULL,
                'logo_width' => NULL,
                'background' => '1587729772.jpeg',
                'popup_title' => 'Mainkan angkamu',
                'popup_content' => '<center>
<p><img alt="" src="https://4.bp.blogspot.com/-0VskR2Fwm2k/V7PQ_EvfhXI/AAAAAAAB_0c/eDLlmCx6syQiHcQ94dbzG0gIoqVpIf5TgCLcB/s1600/3%2BLee%2BDa%2BHee%2B-%2BSeoul%2BAuto%2BSalon%2B-%2Bvery%2Bcute%2Basian%2Bgirl-girlcute4u.blogspot.com.gif" /></p>

<p><big>-- test popup yaachhh&nbsp;mmuaaccchhhhh --</big></p>
</center>',
                'popup_status' => 0,
                'popup_timeout' => 3,
                'launching_date' => NULL,
            ),
        ));
        
        
    }
}