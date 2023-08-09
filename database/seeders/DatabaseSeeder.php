<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Magazine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
				$this->call([
					PermissionsSeeer::class,
					BookSeeder::class,
					MagazineSeeder::class,
					PublicationSeeder::class,
					InvestigationSeeder::class,
				]);
    }
}
