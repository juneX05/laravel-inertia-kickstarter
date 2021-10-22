<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Permissions\Seeders\PermissionsSeeder;
use Modules\Core\Users\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        $this->call([
                        UsersSeeder::class,
                        PermissionsSeeder::class,
                    ]);
    }
}
