<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'subscription_type' => 'free',
            'type' => 'daily',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
        ]);
        $role = Role::query()->create(['name' => 'Admin']);

        $user->assignRole($role);

        Role::query()->create(['name' => 'User']);

    }
}
