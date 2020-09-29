<?php

use Illuminate\Database\Seeder;

class OrchardpoolsFooterTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orchardpools_footer')->delete();
        
        \DB::table('orchardpools_footer')->insert(array (
            0 => 
            array (
                'id' => 1,
                'content' => '<p>susu sapi Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ullamcorper ex est, eu hendrerit augue blandit eu.</p>',
            ),
            1 => 
            array (
                'id' => 2,
                'content' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'content' => '<p>yogurt Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ullamcorper ex est, eu hendrerit augue blandit eu.</p>',
            ),
            3 => 
            array (
                'id' => 4,
                'content' => NULL,
            ),
        ));
        
        
    }
}