<?php

namespace Modules\System;

use Illuminate\Database\Seeder;
use Modules\System\Projects\Seeders\ProjectsSeeder;
use Modules\System\Dashboard\Seeders\DashboardSeeder;
use Modules\System\Generators\Seeders\GeneratorSeeder;

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
                        ProjectsSeeder::class,
                        DashboardSeeder::class,
                        GeneratorSeeder::class,
                    ]);
    }
}
