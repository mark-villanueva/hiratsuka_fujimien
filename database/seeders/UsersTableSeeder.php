<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    public function run()
{
    $faker = Faker::create('ja_JP'); // Use Japanese locale if needed

    // Superadmin user
    $sid = Str::uuid();
    DB::table('users')->insert([
        'id' => $sid,
        'username' => 'superadmin',
        'name' => 'Super',
        'name_kana' => 'Admin',
        'gender' => 'male',
        'email' => 'superadmin@example.com',
        'email_verified_at' => now(),
        'password' => Hash::make('superadmin'),
        'employment_form' => 'corporation_employed_staff',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Bind superadmin user to FilamentShield
    Artisan::call('shield:super-admin', ['--user' => $sid]);

    $roles = DB::table('roles')->whereNot('name', 'super_admin')->get();
    foreach ($roles as $role) {
        for ($i = 0; $i < 10; $i++) {
            $userId = Str::uuid();
            DB::table('users')->insert([
                'id' => $userId,
                'username' => $faker->unique()->userName,
                'name' => $faker->name,
                'name_kana' => $faker->lastName . ' ' . $faker->firstName, // Simulating name_kana
                'gender' => $faker->randomElement(['male', 'female', 'other']), // Custom gender values
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'employment_form' => $faker->randomElement(['full_time', 'part_time', 'contract']), // Custom employment type
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $userId,
            ]);
        }
    }
}
}

