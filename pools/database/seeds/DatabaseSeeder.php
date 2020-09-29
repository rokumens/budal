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

        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(PermissionUserTableSeeder::class);
        $this->call(ThemesTableSeeder::class);
        $this->call(ActivationsTableSeeder::class);
        $this->call(CacheTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(Laravel2stepTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(SocialLoginsTableSeeder::class);
        $this->call(TimezoneTableSeeder::class);
        $this->call(OrchardpoolsSeoTableSeeder::class);
        $this->call(OrchardpoolsSettingsTableSeeder::class);
        $this->call(OrchardpoolsSocialsTableSeeder::class);
        $this->call(OrchardpoolsFooterTableSeeder::class);
        $this->call(OrchardpoolsScriptsTableSeeder::class);

        Model::reguard();
    }
}
