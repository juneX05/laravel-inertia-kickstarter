<?php

namespace Application\Modules\Configurations\SysConfigs\Tabs\Currencies\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();

        $Currencies = [
            ['name' => 'Tanzanian Shilling', 'abbreviation' => 'TZS', 'symbol' => '', 'base' => 0, 'rate' => 2300],
            ['name' => 'United States Dollar', 'abbreviation' => 'USD', 'symbol' => '$', 'base' => 1, 'rate' => 1],
        ];
        DB::table('currencies')->insert($Currencies);
    }

    private function setUpPermissions() {
        $permissions = [
            ['name' => 'currencies.view', 'title' => 'View Currencies',],
            ['name' => 'currency.create', 'title' => 'Create Currency',],
            ['name' => 'currency.edit', 'title' => 'Edit Currency',],
            ['name' => 'currency.delete', 'title' => 'Delete Currency',],
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
