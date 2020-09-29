<?php

use Illuminate\Database\Seeder;

class OrchardpoolsSeoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orchardpools_seo')->delete();
        
        \DB::table('orchardpools_seo')->insert(array (
            0 => 
            array (
                'id' => 1,
                'menu_name' => 'home',
                'title' => 'Homepage | OrchardPools.com',
                'keyword' => 'togel,nomor,keberuntungan, judi, angka keberuntungan, cepet kaya',
                'description' => 'Tempat keluaran nomor yang akurat dan sangat terpercaya. Ubah ini di settings > seo > home > description.',
                'canonical' => 'https://orchardpools.com',
                'url' => 'https://orchardpools.com',
                'property' => 'articles',
                'image' => NULL,
                'content' => NULL,
                'created_at' => '2020-04-13 02:17:54',
                'updated_at' => '2020-04-14 08:52:53',
            ),
            1 => 
            array (
                'id' => 2,
                'menu_name' => 'result',
                'title' => 'Result | OrchardPools.com',
                'keyword' => 'togel,nomor,keberuntungan, judi, angka keberuntungan, cepet kaya',
                'description' => 'Result of OrchardPools.com',
                'canonical' => 'https://orchardpools.com',
                'url' => 'https://orchardpools.com',
                'property' => 'articles',
                'image' => NULL,
                'content' => '<h5>Result Page</h5>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>',
                'created_at' => '2020-04-13 02:17:54',
                'updated_at' => '2020-04-13 02:17:54',
            ),
            2 => 
            array (
                'id' => 3,
                'menu_name' => 'livedraw',
                'title' => 'Live Draw | OrchardPools.com',
                'keyword' => 'togel,nomor,keberuntungan, judi, angka keberuntungan, cepet kaya',
                'description' => 'Live Draw of OrchardPools.com',
                'canonical' => 'https://orchardpools.com',
                'url' => 'https://orchardpools.com',
                'property' => 'articles',
                'image' => NULL,
                'content' => '<h5>Livedraw Page</h5>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>',
                'created_at' => '2020-04-13 02:17:54',
                'updated_at' => '2020-04-13 02:17:54',
            ),
            3 => 
            array (
                'id' => 4,
                'menu_name' => 'about',
                'title' => 'About Us | OrchardPools.com',
                'keyword' => 'togel,nomor,keberuntungan, judi, angka keberuntungan, cepet kaya',
                'description' => 'About Us of OrchardPools.com',
                'canonical' => 'https://orchardpools.com',
                'url' => 'https://orchardpools.com',
                'property' => 'articles',
                'image' => NULL,
                'content' => '<h2>Welcome to Orchard Pools</h2>

<h4>Try your lucky number with us now!</h4>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, voluptatibus dolorum consequatur, ea unde soluta enim exercitationem eveniet inventore iusto qui omnis nesciunt dignissimos assumenda modi illum, suscipit tenetur voluptate.</p>

<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae iste nihil voluptas similique facilis debitis harum asperiores possimus distinctio consequuntur, velit ducimus consectetur mollitia, rerum nulla dolor voluptatem recusandae iure.</p>

<p>&nbsp;</p>

<p>Hari ini adalah hari kamis</p>',
                'created_at' => '2020-04-13 02:17:54',
                'updated_at' => '2020-04-13 02:17:54',
            ),
            4 => 
            array (
                'id' => 5,
                'menu_name' => 'contact',
                'title' => 'Contact Us | OrchardPools.com',
                'keyword' => 'togel,nomor,keberuntungan, judi, angka keberuntungan, cepet kaya',
                'description' => 'Contact Us of OrchardPools.com',
                'canonical' => NULL,
                'url' => NULL,
                'property' => 'articles',
                'image' => NULL,
                'content' => '<h2>Contact us now</h2>

<h4>Lorem ipsum dolor sit amit amit............</h4>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, voluptatibus dolorum consequatur, ea unde soluta enim exercitationem eveniet inventore iusto qui omnis nesciunt dignissimos assumenda modi illum, suscipit tenetur voluptate.</p>

<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae iste nihil voluptas similique facilis debitis harum asperiores possimus distinctio consequuntur, velit ducimus consectetur mollitia, rerum nulla dolor voluptatem recusandae iure.</p>

<p>&nbsp;</p>

<p>buaya abu abu</p>',
                'created_at' => '2020-04-13 02:17:54',
                'updated_at' => '2020-04-13 02:17:54',
            ),
        ));
        
        
    }
}