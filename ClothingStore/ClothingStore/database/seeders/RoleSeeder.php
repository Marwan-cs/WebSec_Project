<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full access to all features and settings',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Access to manage products, orders, and staff',
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Access to basic store operations and customer service',
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Access to customer features and shopping',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 