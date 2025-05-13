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
                'name' => 'IT Staff',
                'slug' => 'it',
                'description' => 'Access to technical features and system maintenance',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Access to basic store operations and customer service',
            ],
            [
                'name' => 'Accountant',
                'slug' => 'accountant',
                'description' => 'Access to financial records and reports',
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