<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * List published blog posts (public).
     *
     * @group Blog
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $sortBy  = in_array($request->query('sort_by'), ['id', 'title', 'created_at'], true)
            ? $request->query('sort_by') : 'created_at';
        $sortDir = $request->query('sort_dir') === 'asc' ? 'asc' : 'desc';

        $blogs = Blog::withRelations()
            ->where('visibility', true)
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return response()->json($blogs);
    }

    /**
     * Show a single published blog post (public).
     *
     * @group Blog
     */
    public function show(int $id): JsonResponse
    {
        $blog = Blog::withRelations()
            ->where('visibility', true)
            ->findOrFail($id);

        return response()->json($blog);
    }

    /**
     * List all blog posts for admin (including hidden).
     *
     * @group         Blog
     *
     * @authenticated
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $sortBy  = in_array($request->query('sort_by'), ['id', 'title', 'created_at', 'visibility'], true)
            ? $request->query('sort_by') : 'created_at';
        $sortDir = $request->query('sort_dir') === 'asc' ? 'asc' : 'desc';

        $blogs = Blog::withRelations()
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return response()->json($blogs);
    }

    /**
     * Create a blog post.
     *
     * @group         Blog
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'excerpt'          => 'nullable|string',
            'content'          => 'required|string',
            'blog_category_id' => 'nullable|integer|exists:blog_categories,id',
            'feature_image'    => 'nullable|string|max:2048',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|max:100',
            'visibility'       => 'boolean',
        ]);

        $data['user_id'] = $request->user()->id;

        $blog = Blog::create($data);
        $blog->load(['author:id,first_name,last_name,name', 'category:id,name,slug']);

        return response()->json($blog, 201);
    }

    /**
     * Update a blog post.
     *
     * @group         Blog
     *
     * @authenticated
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title'            => 'sometimes|required|string|max:255',
            'excerpt'          => 'nullable|string',
            'content'          => 'sometimes|required|string',
            'blog_category_id' => 'nullable|integer|exists:blog_categories,id',
            'feature_image'    => 'nullable|string|max:2048',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|max:100',
            'visibility'       => 'boolean',
        ]);

        $blog->update($data);
        $blog->load(['author:id,first_name,last_name,name', 'category:id,name,slug']);

        return response()->json($blog);
    }

    /**
     * Delete a blog post.
     *
     * @group         Blog
     *
     * @authenticated
     */
    public function destroy(int $id): JsonResponse
    {
        Blog::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
