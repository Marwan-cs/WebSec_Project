<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_users' => 'View Users',
            'create_users' => 'Create Users',
            'edit_users' => 'Edit Users',
            'delete_users' => 'Delete Users',
            'view_roles' => 'View Roles',
            'create_roles' => 'Create Roles',
            'edit_roles' => 'Edit Roles',
            'delete_roles' => 'Delete Roles',
            'view_products' => 'View Products',
            'create_products' => 'Create Products',
            'edit_products' => 'Edit Products',
            'delete_products' => 'Delete Products',
            'view_orders' => 'View Orders',
            'create_orders' => 'Create Orders',
            'edit_orders' => 'Edit Orders',
            'delete_orders' => 'Delete Orders',
            'view_settings' => 'View Settings',
            'edit_settings' => 'Edit Settings',
        ];

        foreach ($permissions as $slug => $name) {
            Permission::create(['name' => $name, 'slug' => $slug]);
        }

        // Create roles and assign permissions
        $roles = [
            'admin' => [
                'name' => 'Administrator',
                'permissions' => array_keys($permissions),
            ],
            'manager' => [
                'name' => 'Manager',
                'permissions' => [
                    'view_users', 'create_users', 'edit_users',
                    'view_products', 'create_products', 'edit_products', 'delete_products',
                    'view_orders', 'create_orders', 'edit_orders',
                    'view_settings',
                ],
            ],
            'staff' => [
                'name' => 'Staff',
                'permissions' => [
                    'view_products',
                    'view_orders', 'create_orders', 'edit_orders',
                ],
            ],
            'customer' => [
                'name' => 'Customer',
                'permissions' => [
                    'view_products',
                    'view_orders', 'create_orders',
                ],
            ],
        ];

        foreach ($roles as $slug => $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'slug' => $slug,
            ]);

            $role->permissions()->attach(
                Permission::whereIn('slug', $roleData['permissions'])->pluck('id')
            );
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $admin->roles()->attach(Role::where('slug', 'admin')->first());
    }
} 