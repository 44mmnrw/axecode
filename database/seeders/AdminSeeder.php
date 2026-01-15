<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@axecode.tech',
            'password' => bcrypt('uNa/s;/BN)CN86\\'),
        ]);
    }
}
