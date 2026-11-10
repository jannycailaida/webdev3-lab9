<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'juan@example.com'],
            [
                'name'     => 'Juan Dela Cruz',
                'password' => Hash::make('password123'),
            ]
        );

        Post::updateOrCreate(
            ['title' => 'Hello API'],
            [
                'user_id' => $user->id,
                'body'    => 'One back end, every client — web, mobile, anything that speaks JSON.',
            ]
        );

        Post::updateOrCreate(
            ['title' => 'Mastering Laravel Sanctum'],
            [
                'user_id' => $user->id,
                'body'    => 'Stateless token authentication using Authorization: Bearer headers.',
            ]
        );
    }
}
