<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_request_returns_401(): void
    {
        $response = $this->getJson('/api/posts');

        $response->assertStatus(401);
    }

    public function test_login_issues_sanctum_token_and_returns_200(): void
    {
        $user = User::factory()->create([
            'email'    => 'juan@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'juan@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'user', 'token']);
    }

    public function test_authenticated_user_can_list_paginated_posts_200(): void
    {
        $user = User::factory()->create(['name' => 'Juan Dela Cruz']);
        Post::create([
            'user_id' => $user->id,
            'title'   => 'Hello API',
            'body'    => 'Sample body',
        ]);

        $token = $user->createToken('mobile')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'body', 'author', 'created_at'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_authenticated_user_can_create_post_201(): void
    {
        $user = User::factory()->create(['name' => 'Juan Dela Cruz']);
        $token = $user->createToken('mobile')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/posts', [
                'title' => 'New Post',
                'body'  => 'Post content here.',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'New Post')
            ->assertJsonPath('data.author', 'Juan Dela Cruz');
    }

    public function test_invalid_post_input_returns_422(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('mobile')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/posts', [
                'title' => '',
                'body'  => '',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'body']);
    }

    public function test_authenticated_user_can_delete_own_post_204(): void
    {
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title'   => 'To Delete',
            'body'    => 'Will be deleted.',
        ]);
        $token = $user->createToken('mobile')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
