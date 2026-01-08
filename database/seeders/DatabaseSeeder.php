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
            UserSeeder::class,
            RegulasiSeeder::class,
            TemplateSuratSeeder::class,
        ]);
    }
}