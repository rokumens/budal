<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        Model::reguard();
        $this->call(ConnectResponseTableSeeder::class);
        $this->call(NextActionTableSeeder::class);
        $this->call(CampaignResultTableSeeder::class);
        $this->call(CategoryGameTableSeeder::class);
        $this->call(CategoryWebTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(ConstantYesnoTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(IconsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
    }
}
