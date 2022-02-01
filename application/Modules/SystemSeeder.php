<?php

namespace Application\Modules;

use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $core_seeders = [
            'Application\Modules\Core\Users\Seeders\UsersSeeder',
            'Application\Modules\Core\Permissions\Seeders\PermissionsSeeder',
            'Application\Modules\Core\Menus\Seeders\MenusSeeder',
            'Application\Modules\System\Dashboard\Seeders\DashboardSeeder',
            'Application\Modules\Configurations\SysConfigs\Seeders\SysConfigsSeeder',
            'Application\Modules\Configurations\DevConfigs\Seeders\DevConfigsSeeder',
        ];

        $system_seeders = [
            'Application\Modules\Configurations\DevConfigs\Tabs\ProjectStatuses\Seeders\ProjectStatusesSeeder',
            'Application\Modules\System\Projects\Seeders\ProjectsSeeder',
        ];


        $this->call(array_merge($core_seeders, $system_seeders));
    }
}
