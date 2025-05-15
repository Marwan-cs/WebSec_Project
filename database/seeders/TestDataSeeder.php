<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Role;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create test products
        $products = [
            [
                'name' => 'Test Product 1',
                'description' => 'This is a test product 1',
                'price' => 99.99,
                'stock' => 100,
            ],
            [
                'name' => 'Test Product 2',
                'description' => 'This is a test product 2',
                'price' => 149.99,
                'stock' => 50,
            ],
            [
                'name' => 'Test Product 3',
                'description' => 'This is a test product 3',
                'price' => 199.99,
                'stock' => 75,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create test roles if they don't exist
        $roles = ['admin', 'manager', 'staff', 'customer'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create test users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@test.com',
                'password' => bcrypt('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@test.com',
                'password' => bcrypt('password'),
                'role' => 'staff',
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@test.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            
            $user = User::create($userData);
            $user->roles()->attach(Role::where('name', $role)->first());
        }
    }
} 