<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\UserManagement\App\Models\User;

class CreateUsersSeeder extends Seeder
{
    public function run()
    {

        // Create or find a super-admin user
        $superAdmin = User::firstOrCreate([
            'login' => 'root_admin',
        ], [
            'name' => 'Root Admin',
            'password' => Hash::make('supersecret123'),
            'role' => 'admin',
            'type' => 'super_admin',  // <--- Sub-classification
            'phone' => '9999999999',
        ]);

        // Assign the admin role
        $superAdmin->assignRole('admin');
        // Create a dealer
        $dealer = User::create([
            'name' => 'Main Dealer',
            'login' => 'dealer',
            'password' => Hash::make('dealer123'),
            'phone' => '1234567890',
            'role' => 'dealer',
        ]);

        $dealer->assignRole('dealer');

        // Create 3 admins
        for ($i = 1; $i <= 3; $i++) {
            $admin = User::create([
                'name' => "Admin $i",
                'login' => "admin$i",
                'password' => Hash::make("admin123$i"),
                'phone' => "12345678$i",
                'role' => 'admin',
            ]);

            $admin->assignRole('admin');
        }

        // Create 17 users linked to the dealer
        for ($i = 1; $i <= 17; $i++) {
            $user = User::create([
                'name' => "User $i",
                'phone' => "98765432$i",
                'role' => 'user',
                // 'dealer_id' => $dealer->id,
                'company_tin' => "TIN12345$i",
                'company_integration_id' => "INT12345$i",
            ]);

            $user->assignRole('user');
        }
    }
}
