<?php

namespace Application\Modules;

use Application\Modules\Core\Menus\Seeders\MenusSeeder;
use Application\Modules\Core\Permissions\Seeders\PermissionsSeeder;
use Application\Modules\Core\Users\Seeders\UsersSeeder;
use Application\Modules\System\Dashboard\Seeders\DashboardSeeder;
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
        $this->call([
            UsersSeeder::class,
            PermissionsSeeder::class,
            MenusSeeder::class,
            DashboardSeeder::class,
        ]);
    }
}
