<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $this->call(RoleSeeder::class); // 1. Create roles first
        // 2. Create a business (you can create more as needed)

        User::firstOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'name' => 'System Super Admin',
            'password' => Hash::make('1234567890'),
            'is_superadmin' => true, // this replaces the need for a 'role' column
            'role_id' => null, //not linked to any role
        ]);

         // 3. Get roles
         $adminRole = Role::where('name', 'admin')->first();
         $userRole = Role::where('name', 'user')->first();
         $user = User::where('email', 'superadmin@gmail.com')->first();
 

     User::factory()->create([
            'name' => 'RentalHub User',
            'email' => 'testuser@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => $userRole->id,
      ]);

           User::factory()->create([
            'name' => 'RentalAdmin',
            'email' => 'testadmin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => $adminRole->id,
      ]);

        $this->call(PropertySeeder::class);
    }
}
