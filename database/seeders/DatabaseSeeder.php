<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'username' => 'tester',
            'password' => Hash::make('1234'),
            'last_login' => now(),
            'is_active' => true,
            'role' => 'manager',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'tester_2',
            'password' => Hash::make('1234'),
            'last_login' => now(),
            'is_active' => true,
            'role' => 'agent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('candidatos')->insert([
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => 2,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}