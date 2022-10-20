<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'is_admin' => false,
        ]);

        \App\Models\Author::factory(10)->create();
        \App\Models\Publisher::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Book::factory(100)->create();
        \App\Models\RentDetail::factory(20)->create();
        \App\Models\PurchaseDetail::factory(20)->create();
    }
}
