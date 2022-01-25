<?php

namespace Application\Modules\Configurations\SysConfigs\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();

//        $Configurations = [
//            ''
//        ];
//        DB::table('configurations')->insert($Configurations);
    }

    private function setUpPermissions()
    {
        $permissions = [
            ['name' => 'configurations.view', 'title' => 'View Configurations',],
            ['name' => 'configuration.view', 'title' => 'View Configuration',],
            ['name' => 'configuration.create', 'title' => 'Create Configuration',],
            ['name' => 'configuration.edit', 'title' => 'Edit Configuration',],
            ['name' => 'configuration.delete', 'title' => 'Delete Configuration',],
        ];
        DB::table('permissions')->insert($permissions);

        foreach ($permissions as $permission) {
            DB::table('user_permissions')
                ->insert([
                    'user_id' => 1,
                    'permission_name' => $permission['name'],
                    'status' => 1,
                ]);
        }
    }
}
