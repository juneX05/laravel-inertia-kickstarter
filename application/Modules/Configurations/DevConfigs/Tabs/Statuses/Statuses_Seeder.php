<?php

namespace Application\Modules\Configurations\DevConfigs\Tabs\Statuses;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Statuses_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();

        $Statuses = [
            ['name' => 'Active', 'id' => 1],
            ['name' => 'InActive', 'id' => 2],
        ];
        DB::table('statuses')->insert($Statuses);
    }

    private function setUpPermissions() {
        $permissions = [
            ['name' => 'statuses.view', 'title' => 'View Statuses',],
            ['name' => 'status.create', 'title' => 'Create Status',],
            ['name' => 'status.edit', 'title' => 'Edit Status',],
            ['name' => 'status.delete', 'title' => 'Delete Status',],
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
