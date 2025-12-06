<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = 'rutujashinde0305@gmail.com';

        // Downgrade any other admins to staff to ensure a single admin
        User::where('role', 'admin')
            ->where('email', '!=', $adminEmail)
            ->update(['role' => 'staff']);

        // Create or update the designated admin user
        $admin = User::firstOrNew(['email' => $adminEmail]);
        $admin->name = 'Admin User';
        $admin->role = 'admin';
        $admin->email_verified_at = $admin->email_verified_at ?: now();
        $admin->password = Hash::make('admin123');
        $admin->save();
    }
}
