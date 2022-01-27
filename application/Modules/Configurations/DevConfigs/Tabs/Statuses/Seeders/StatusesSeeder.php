<?php

namespace Application\Modules\Configurations\DevConfigs\Tabs\Statuses\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
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
            ['name' => 'Tanzanian Shilling', 'abbreviation' => 'TZS', 'symbol' => '', 'base' => 0, 'rate' => 2300],
            ['name' => 'United States Dollar', 'abbreviation' => 'USD', 'symbol' => '$', 'base' => 1, 'rate' => 1],
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
