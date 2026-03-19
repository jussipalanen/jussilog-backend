<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillCategoryController extends Controller
{
    /**
     * List all skill categories with their skills.
     *
     * @group Skill Categories
     */
    public function index(): JsonResponse
    {
        return response()->json(
            SkillCategory::orderBy('sort_order')->with('skills:id,skill_category_id,name')->get()
        );
    }

    /**
     * List skills for a specific category.
     *
     * @group Skill Categories
     */
    public function skills(int $id): JsonResponse
    {
        $category = SkillCategory::findOrFail($id);

        return response()->json($category->skills()->orderBy('name')->get(['id', 'name']));
    }

    /**
     * Create a skill category.
     *
     * @group         Skill Categories
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100|unique:skill_categories,name',
            'slug'       => 'required|string|max:100|unique:skill_categories,slug',
            'sort_order' => 'integer|min:0',
        ]);

        $category = SkillCategory::create($data);

        return response()->json($category, 201);
    }

    /**
     * Update a skill category.
     *
     * @group         Skill Categories
     *
     * @authenticated
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $category = SkillCategory::findOrFail($id);

        $data = $request->validate([
            'name'       => 'string|max:100|unique:skill_categories,name,'.$id,
            'slug'       => 'string|max:100|unique:skill_categories,slug,'.$id,
            'sort_order' => 'integer|min:0',
        ]);

        $category->update($data);

        return response()->json($category);
    }

    /**
     * Delete a skill category.
     *
     * @group         Skill Categories
     *
     * @authenticated
     */
    public function destroy(int $id): JsonResponse
    {
        SkillCategory::findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    /**
     * Add a skill to a category.
     *
     * @group         Skill Categories
     *
     * @authenticated
     */
    public function storeSkill(Request $request, int $id): JsonResponse
    {
        $category = SkillCategory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $skill = $category->skills()->create($data);

        return response()->json($skill, 201);
    }

    /**
     * Update a skill.
     *
     * @group         Skill Categories
     *
     * @authenticated
     */
    public function updateSkill(Request $request, int $id, int $skillId): JsonResponse
    {
        $category = SkillCategory::findOrFail($id);

        $skill = $category->skills()->findOrFail($skillId);

        $data = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $skill->update($data);

        return response()->json($skill);
    }

    /**
     * Delete a skill.
     *
     * @group         Skill Categories
     *
     * @authenticated
     */
    public function destroySkill(int $id, int $skillId): JsonResponse
    {
        $category = SkillCategory::findOrFail($id);

        $category->skills()->findOrFail($skillId)->delete();

        return response()->json(null, 204);
    }
}
