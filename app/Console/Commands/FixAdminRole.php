<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class FixAdminRole extends Command
{
    protected $signature = 'fix:admin-role';
    protected $description = 'Ensure the admin user is assigned the admin role by slug';

    public function handle()
    {
        $user = User::where('email', 'admin@example.com')->first();
        $role = Role::where('slug', 'admin')->first();
        if (!$user) {
            $this->error('Admin user not found.');
            return 1;
        }
        if (!$role) {
            $this->error('Admin role not found.');
            return 1;
        }
        $user->roles()->syncWithoutDetaching([$role->id]);
        $this->info('Admin user assigned to admin role successfully.');
        return 0;
    }
} 