<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create test products
        $products = [
            [
                'name' => 'Test Product 1',
                'description' => 'This is a test product description.',
                'price' => 99.99,
                'stock' => 100,
                'is_featured' => true,
                'is_sale' => false,
                'image_url' => '/img/product/product-1.jpg',
            ],
            [
                'name' => 'Test Product 2',
                'description' => 'Another test product description.',
                'price' => 149.99,
                'stock' => 50,
                'is_featured' => true,
                'is_sale' => true,
                'image_url' => '/img/product/product-2.jpg',
            ],
            [
                'name' => 'Test Product 3',
                'description' => 'Yet another test product description.',
                'price' => 199.99,
                'stock' => 75,
                'is_featured' => false,
                'is_sale' => true,
                'image_url' => '/img/product/product-3.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }

        // Create test roles if they don't exist
        $roles = ['admin', 'manager', 'staff', 'customer'];
        foreach ($roles as $role) {
            \App\Models\Role::updateOrCreate(
                ['slug' => $role],
                ['name' => $role, 'slug' => $role]
            );
        }

        // Create test users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                ]
            );

            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }
        }
    }
} 