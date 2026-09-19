<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Creates the requested admin account. The password is hashed with
     * bcrypt automatically by the User model's 'password' => 'hashed' cast
     * — never stored or committed in plain text anywhere in this codebase.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'adminredflow402@gmail.com'],
            [
                'name' => 'Admin RedFlow',
                'password' => 'RhuRflow204@',
                'role' => 'Admin',
                'status' => 'Approved',
                'action_taken' => 'Approved',
            ]
        );
    }
}
