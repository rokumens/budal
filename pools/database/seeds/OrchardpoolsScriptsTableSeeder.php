<?php

use Illuminate\Database\Seeder;

class OrchardpoolsScriptsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orchardpools_scripts')->delete();
        
        \DB::table('orchardpools_scripts')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'test javascript popup',
                'script' => '<script>
window.alert("testing script from setting > general");
</script>',
                'priority' => 5,
                'active' => 0,
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'test meta index follow',
                'script' => '<meta name="target" content="index, follow">',
                'priority' => 1,
                'active' => 0,
            ),
            2 => 
            array (
                'id' => 7,
                'name' => 'Test Tawk.to',
                'script' => '<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src=\'https://embed.tawk.to/5e469341a89cda5a1885f806/default\';
s1.charset=\'UTF-8\';
s1.setAttribute(\'crossorigin\',\'*\');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->',
                'priority' => 6,
                'active' => 0,
            ),
        ));
        
        
    }
}