<?php

namespace App\Http\Controllers;

use App\Models\ProjectTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Handles project tag endpoints.
 */
class ProjectTagController extends Controller
{
    /**
     * List all project tags.
     *
     * @group Project Tags
     */
    public function index(): JsonResponse
    {
        return response()->json(ProjectTag::orderBy('title')->get());
    }

    /**
     * Create a project tag.
     *
     * @group         Project Tags
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:100|unique:project_tags,title',
            'color' => 'required|string|max:50',
        ]);

        $tag = ProjectTag::create($data);

        return response()->json($tag, 201);
    }

    /**
     * Update a project tag.
     *
     * @group         Project Tags
     *
     * @authenticated
     *
     * @urlParam id integer required The tag ID. Example: 1
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $tag = ProjectTag::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:100|unique:project_tags,title,' . $id,
            'color' => 'sometimes|required|string|max:50',
        ]);

        $tag->update($data);

        return response()->json($tag);
    }

    /**
     * Delete a project tag.
     *
     * @group         Project Tags
     *
     * @authenticated
     *
     * @urlParam id integer required The tag ID. Example: 1
     */
    public function destroy(int $id): JsonResponse
    {
        ProjectTag::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
