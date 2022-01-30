<?php

namespace Application\Modules\Core\Menus\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();

//        $Menus = [
//            ''
//        ];
//        DB::table('Menus')->insert($Menus);
    }

    private function setUpPermissions() {
        $permissions = [
            ['name' => 'menus.view', 'title' => 'View Menus',],
            ['name' => 'menu.create', 'title' => 'Create Menu',],
            ['name' => 'menu.edit', 'title' => 'Edit Menu',],
            ['name' => 'menu.delete', 'title' => 'Delete Menu',],
            ['name' => 'menu.manage_positions', 'title' => 'Manage Menu Positions',],
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
