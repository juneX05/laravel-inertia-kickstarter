<?php

namespace Application\Modules\Configurations\SysConfigs;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysConfigs_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();

        $seeders = [
            'Application\Modules\Configurations\SysConfigs\Tabs\Currencies\Currencies_Seeder',
        ];

        $this->call($seeders);
    }

    private function setUpPermissions()
    {
        $permissions = [
            ['name' => 'sys_configs.view', 'title' => 'View SysConfigs',],
            ['name' => 'sys_config.view', 'title' => 'View SysConfig',],
            ['name' => 'sys_config.create', 'title' => 'Create SysConfig',],
            ['name' => 'sys_config.edit', 'title' => 'Edit SysConfig',],
            ['name' => 'sys_config.delete', 'title' => 'Delete SysConfig',],
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
