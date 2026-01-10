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
                'id_ruangan' => 1,
                'password' => Hash::make('admin123')
            ],
            [
                'username' => 'direktur',
                'id_ruangan' => 2,
                'password' => Hash::make('direktur123')
            ],
            [
                'username' => 'tatausaha',
                'id_ruangan' => 3,
                'password' => Hash::make('tatausaha123')
            ],
            [
                'username' => 'pelayanan',
                'id_ruangan' => 4,
                'password' => Hash::make('pelayanan123')
            ],
            [
                'username' => 'pengembangan',
                'id_ruangan' => 5,
                'password' => Hash::make('pengembangan123')
            ],
            [
                'username' => 'pengadaan',
                'id_ruangan' => 6,
                'password' => Hash::make('pengadaan123')
            ],
            [
                'username' => 'keuangan',
                'id_ruangan' => 7,
                'password' => Hash::make('keuangan123')
            ],
            [
                'username' => 'keperawatan',
                'id_ruangan' => 8,
                'password' => Hash::make('keperawatan123')
            ],
            [
                'username' => 'farmasi',
                'id_ruangan' => 9,
                'password' => Hash::make('farmasi123')
            ],
            [
                'username' => 'itrsud',
                'id_ruangan' => 10,
                'password' => Hash::make('itrsud123')
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
