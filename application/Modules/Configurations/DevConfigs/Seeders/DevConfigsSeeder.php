<?php

namespace Application\Modules\Configurations\DevConfigs\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();

//        $DevConfigs = [
//            ''
//        ];
//        DB::table('dev_configs')->insert($DevConfigs);
    }

    private function setUpPermissions()
    {
        $permissions = [
            ['name' => 'dev_configs.view', 'title' => 'View DevConfigs',],
            ['name' => 'dev_config.view', 'title' => 'View DevConfig',],
            ['name' => 'dev_config.create', 'title' => 'Create DevConfig',],
            ['name' => 'dev_config.edit', 'title' => 'Edit DevConfig',],
            ['name' => 'dev_config.delete', 'title' => 'Delete DevConfig',],
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
