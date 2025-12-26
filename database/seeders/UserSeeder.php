<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'id_ruangan' => 1, // Admin
                'password' => Hash::make('admin123')
            ],
            [
                'username' => 'direktur',
                'id_ruangan' => 2, // Direktur
                'password' => Hash::make('direktur123')
            ],
            [
                'username' => 'tatausaha',
                'id_ruangan' => 3, // Tata Usaha
                'password' => Hash::make('tatausaha123')
            ],
            [
                'username' => 'pelayanan',
                'id_ruangan' => 4, // Pelayanan
                'password' => Hash::make('pelayanan123')
            ],
            [
                'username' => 'keperawatan',
                'id_ruangan' => 5, // Keperawatan
                'password' => Hash::make('keperawatan123')
            ],
            [
                'username' => 'it',
                'id_ruangan' => 6, // IT
                'password' => Hash::make('it123')
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['username' => $user['username']],
                [
                    'id_ruangan' => $user['id_ruangan'],
                    'password' => $user['password']
                ]
            );
        }
    }
}
