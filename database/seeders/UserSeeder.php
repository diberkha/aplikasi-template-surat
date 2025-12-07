<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id_ruangan' => 1,
            'username' => 'admin',
            'password' => Hash::make('admin123')
        ]);

        User::create([
            'id_ruangan' => 2,
            'username' => 'user1',
            'password' => Hash::make('user1234')
        ]);
    }
}
