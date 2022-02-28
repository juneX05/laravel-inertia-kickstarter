<?php

namespace Application\Modules\Configurations\DevConfigs;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevConfigs_Seeder extends Seeder
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
            'Application\Modules\Configurations\DevConfigs\Tabs\Statuses_Seeder',
        ];

        $this->call($seeders);
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
