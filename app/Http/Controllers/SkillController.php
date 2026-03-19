<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * List all skills, optionally filtered by category or search query.
     *
     * @group Skills
     */
    public function index(Request $request): JsonResponse
    {
        $query = Skill::with('category:id,name,slug')->orderBy('name');

        if ($categoryId = $request->query('category_id')) {
            $query->where('skill_category_id', $categoryId);
        }

        if ($search = $request->query('search')) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        return response()->json($query->get());
    }

    /**
     * Create a skill.
     *
     * @group         Skills
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'skill_category_id' => 'nullable|integer|exists:skill_categories,id',
        ]);

        $skill = Skill::create($data);
        $skill->load('category:id,name,slug');

        return response()->json($skill, 201);
    }

    /**
     * Update a skill.
     *
     * @group         Skills
     *
     * @authenticated
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $skill = Skill::findOrFail($id);

        $data = $request->validate([
            'name'              => 'string|max:100',
            'skill_category_id' => 'nullable|integer|exists:skill_categories,id',
        ]);

        $skill->update($data);
        $skill->load('category:id,name,slug');

        return response()->json($skill);
    }

    /**
     * Delete a skill.
     *
     * @group         Skills
     *
     * @authenticated
     */
    public function destroy(int $id): JsonResponse
    {
        Skill::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
