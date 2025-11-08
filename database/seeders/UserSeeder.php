<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'nysainana@dna.mg'],
            [
                'name' => 'Ny Sainana',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
            ]
        );

        $user->assignRole(RoleName::SUPER_ADMIN->value);
    }
}
