<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * List all blog categories.
     *
     * @group  Blog Categories
     */
    public function index(): JsonResponse
    {
        return response()->json(BlogCategory::orderBy('name')->get());
    }

    /**
     * Create a blog category.
     *
     * @group         Blog Categories
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name',
        ]);

        $category = BlogCategory::create($data);

        return response()->json($category, 201);
    }

    /**
     * Update a blog category.
     *
     * @group         Blog Categories
     *
     * @authenticated
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $category = BlogCategory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name,' . $id,
        ]);

        $category->update($data);

        return response()->json($category);
    }

    /**
     * Delete a blog category.
     *
     * @group         Blog Categories
     *
     * @authenticated
     */
    public function destroy(int $id): JsonResponse
    {
        BlogCategory::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
