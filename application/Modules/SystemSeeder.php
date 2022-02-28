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
            'Application\Modules\Core\Users\Users_Seeder',
            'Application\Modules\Core\Permissions\Permissions_Seeder',
            'Application\Modules\Core\Menus\Menus_Seeder',
            'Application\Modules\System\Dashboard\Dashboard_Seeder',
            'Application\Modules\Configurations\SysConfigs\SysConfigs_Seeder',
            'Application\Modules\Configurations\DevConfigs\DevConfigs_Seeder',
        ];

        $system_seeders = [

        ];


        $this->call(array_merge($core_seeders, $system_seeders));
    }
}
