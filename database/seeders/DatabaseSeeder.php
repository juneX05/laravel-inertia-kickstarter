<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Application\Modules\SystemSeeder;

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
                        SystemSeeder::class,
                    ]);
    }
}
