<?php

namespace Application\Modules\Core\Users\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Application\Modules\Core\Users\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seed user permissions
        $this->setUpPermissions();

        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('secret'),
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('secret'),
            ]
        );
    }

    private function setUpPermissions() {
        $permissions = [
            ['name' => 'users.view', 'title' => 'View Users',],
            ['name' => 'user.create', 'title' => 'Create user',],
            ['name' => 'user.delete', 'title' => 'delete user',],
            ['name' => 'user.edit', 'title' => 'edit user',],
            ['name' => 'user.manage.user.permissions', 'title' => 'Manage User Permissions',],
            ['name' => 'user.reset.password', 'title' => 'Reset User Password',],
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
