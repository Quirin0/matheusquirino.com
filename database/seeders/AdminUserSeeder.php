<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Matheus Quirino',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('admin'),
            ]
        );
    }
}
