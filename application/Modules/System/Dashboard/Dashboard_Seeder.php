<?php

namespace Application\Modules\System\Dashboard;

use Application\Modules\Core\Permissions\Permission_Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Dashboard_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpPermissions();
    }

    private function setUpPermissions() {
        $permissions = [
            ['name' => 'dashboard.view', 'title' => 'View Dashboard',],
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
