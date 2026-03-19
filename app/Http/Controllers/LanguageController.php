<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * List all languages, optionally filtered by search query.
     *
     * @group Languages
     */
    public function index(Request $request): JsonResponse
    {
        $query = Language::orderBy('name');

        if ($search = $request->query('search')) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        return response()->json($query->get(['id', 'code', 'name']));
    }

    /**
     * Create a language.
     *
     * @group         Languages
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:languages,name',
            'code' => 'required|string|max:10|unique:languages,code',
        ]);

        $language = Language::create($data);

        return response()->json($language, 201);
    }

    /**
     * Update a language.
     *
     * @group         Languages
     *
     * @authenticated
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $language = Language::findOrFail($id);

        $data = $request->validate([
            'name' => 'string|max:100|unique:languages,name,'.$id,
            'code' => 'string|max:10|unique:languages,code,'.$id,
        ]);

        $language->update($data);

        return response()->json($language);
    }

    /**
     * Delete a language.
     *
     * @group         Languages
     *
     * @authenticated
     */
    public function destroy(int $id): JsonResponse
    {
        Language::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
