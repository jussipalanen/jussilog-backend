<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Handles project category endpoints.
 */
class ProjectCategoryController extends Controller
{
    /**
     * List all project categories.
     *
     * @group Project Categories
     */
    public function index(): JsonResponse
    {
        return response()->json(ProjectCategory::orderBy('title')->get());
    }

    /**
     * Create a project category.
     *
     * @group         Project Categories
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:100|unique:project_categories,title',
        ]);

        $category = ProjectCategory::create($data);

        return response()->json($category, 201);
    }

    /**
     * Update a project category.
     *
     * @group         Project Categories
     *
     * @authenticated
     *
     * @urlParam id integer required The category ID. Example: 1
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $category = ProjectCategory::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:100|unique:project_categories,title,'.$id,
        ]);

        $category->update($data);

        return response()->json($category);
    }

    /**
     * Delete a project category.
     *
     * @group         Project Categories
     *
     * @authenticated
     *
     * @urlParam id integer required The category ID. Example: 1
     */
    public function destroy(int $id): JsonResponse
    {
        ProjectCategory::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
