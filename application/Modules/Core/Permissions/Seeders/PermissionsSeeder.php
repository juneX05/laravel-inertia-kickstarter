<?php

namespace Application\Modules\Core\Permissions\Seeders;

use Application\Modules\Core\Permissions\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'permissions.view', 'title' => 'View Permissions',],
            ['name' => 'permission.create', 'title' => 'Create permission',],
            ['name' => 'permission.manage.users', 'title' => 'manage user permission',],
            ['name' => 'permission.edit', 'title' => 'Edit permission',],
            ['name' => 'permission.delete', 'title' => 'Delete permission',],


//            ['name' => 'questions.view', 'title' => 'View Questions',],
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
