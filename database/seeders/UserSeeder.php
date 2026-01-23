<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'amit.owninfotech@gmail.com'],
            [
                'first_name' => 'Amit',
                'last_name' => 'Owninfotech',
                'email' => 'amit.owninfotech@gmail.com',
                'password' => Hash::make('amit.owninfotech@gmail.comA1'),
                'family_relation' => 'admin',
                'role' => 'admin',
                'is_admin' => true,
                'phone' => '+1234567890',
                'address' => '123 Admin Street, Admin City, Admin State 12345',
                'date_of_birth' => '1990-01-01',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Default admin user created successfully!');
        $this->command->info('Email: amit.owninfotech@gmail.com');
        $this->command->info('Password: amit.owninfotech@gmail.comA1');
    }
}
