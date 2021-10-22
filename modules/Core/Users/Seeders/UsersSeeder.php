<?php

namespace Modules\Core\Users\Seeders;

use Modules\Core\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                         'name' => 'Joel Kibona',
                         'email' => 'joelvankibona@gmail.com',
                         'password' => Hash::make('joelinho'),
                     ]);
    }
}
