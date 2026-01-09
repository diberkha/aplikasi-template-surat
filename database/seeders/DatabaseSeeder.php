<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RuanganSeeder::class,
            UnitSeeder::class,
            JabatanSeeder::class,
            UserSeeder::class,
            TemplateSuratSeeder::class,
        ]);
    }
}