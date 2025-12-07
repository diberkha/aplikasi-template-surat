<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RuanganSeeder::class,
            TemplateSuratSeeder::class,
            UserSeeder::class,
            SuratSeeder::class,
            RegulasiSeeder::class,
        ]);
    }
}