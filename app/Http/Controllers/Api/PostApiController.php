<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * GET /api/posts
     * Return paginated list of posts with eager-loaded author (200 OK).
     */
    public function index()
    {
        return PostResource::collection(
            Post::with('user')->latest()->paginate(10)
        );
    }

    /**
     * POST /api/posts
     * Validate and create a new post (201 Created, or 422 Unprocessable Content).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body'  => ['required', 'string'],
        ]);

        $post = $request->user()->posts()->create($validated);
        $post->load('user');

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * GET /api/posts/{post}
     * Return a single post transformed by PostResource (200 OK, or 404 Not Found).
     */
    public function show(Post $post)
    {
        $post->load('user');

        return new PostResource($post);
    }

    /**
     * PUT/PATCH /api/posts/{post}
     * Validate and update an existing post (200 OK, 403 Forbidden, or 422 Unprocessable Content).
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden. You do not own this post.',
            ], 403);
        }

        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'body'  => ['sometimes', 'required', 'string'],
        ]);

        $post->update($validated);
        $post->load('user');

        return new PostResource($post);
    }

    /**
     * DELETE /api/posts/{post}
     * Delete a post and return 204 No Content.
     */
    public function destroy(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden. You do not own this post.',
            ], 403);
        }

        $post->delete();

        return response()->noContent();
    }
}
