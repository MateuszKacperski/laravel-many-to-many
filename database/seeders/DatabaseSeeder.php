<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        

         \App\Models\User::factory()->create([
             'name' => 'Mateusz',
             'email' => 'mateusz@test.it',
         ]);
          
         $this->call(TypeSeeder::class);

         \App\Models\Project::factory(30)->create();
    }
}
