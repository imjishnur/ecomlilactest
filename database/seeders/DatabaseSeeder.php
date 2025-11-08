<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
         User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
             'role' => 1,
          
        ]);
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

        Product::create([
            'name' => 'Sample Product',
            'description' => 'test',
           
            'qty' => 10,
            'price' => 199.99,
            
        ]);
        

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
