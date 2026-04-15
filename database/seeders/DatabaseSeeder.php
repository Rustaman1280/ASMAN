<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JurusanSeeder::class,
            RuanganSeeder::class,
            SupplierSeeder::class,
            BarangSeeder::class,
        ]);

        \Illuminate\Support\Facades\Artisan::call('app:sync-unit-barangs');
        $this->command->info('Unit barangs synced successfully.');
    }
}
