<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name'      =>  'Jhon Doe',
            'email'     =>  'jhon@gmail.com',
            'password'  =>  Hash::make('root'),
            'role'      =>  'admin',
        ]);
        \App\Models\User::factory()->create([
            'name'      =>  'Susi Susanti',
            'email'     =>  'susi@gmail.com',
            'password'  =>  Hash::make('root'),
            'role'      =>  'kontributor',
        ]);
        \App\Models\User::factory()->create([
            'name'      =>  'Putri Wati',
            'email'     =>  'putri@gmail.com',
            'password'  =>  Hash::make('root'),
            'role'      =>  'user',
        ]);

        \App\Models\Category::factory()->create([
            'name'      => 'Uncategorized',
            'slug'      => 'uncategorized',
            'user_id'   =>  1,
        ]);
    }
}
