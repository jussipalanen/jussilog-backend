<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Models\Resume;
use App\Models\ResumeCertification;
use App\Models\ResumeRecommendation;
use App\Models\ResumeEducation;
use App\Models\ResumeLanguage;
use App\Models\ResumeAward;
use App\Models\ResumeProject;
use App\Models\ResumeSkill;
use App\Models\ResumeWorkExperience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResumeItemController extends Controller
{
    private static array $sectionMap = [
        'work-experiences' => ResumeWorkExperience::class,
        'educations'       => ResumeEducation::class,
        'skills'           => ResumeSkill::class,
        'projects'         => ResumeProject::class,
        'certifications'   => ResumeCertification::class,
        'languages'        => ResumeLanguage::class,
        'awards'           => ResumeAward::class,
        'recommendations'  => ResumeRecommendation::class,
    ];

    /**
     * List all items in a resume section.
     *
     * @group Resume Sections
     * @authenticated
     * @urlParam resumeId integer required Resume ID. Example: 1
     * @urlParam section string required Section slug. Example: work-experiences
     */
    public function index(Request $request, int $resumeId, string $section): JsonResponse
    {
        $resume = $this->findResume($request, $resumeId);
        $modelClass = $this->resolveSection($section);

        $items = $modelClass::where('resume_id', $resume->id)->orderBy('sort_order')->get();

        return response()->json($items);
    }

    /**
     * Add an item to a resume section.
     *
     * @group Resume Sections
     * @authenticated
     * @urlParam resumeId integer required Resume ID. Example: 1
     * @urlParam section string required Section slug. Example: work-experiences
     */
    public function store(Request $request, int $resumeId, string $section): JsonResponse
    {
        $resume = $this->findResume($request, $resumeId);
        $modelClass = $this->resolveSection($section);

        $data = $request->validate($this->validationRules($section));

        $item = $modelClass::create(array_merge($data, ['resume_id' => $resume->id]));

        return response()->json($item, 201);
    }

    /**
     * Update an item in a resume section.
     *
     * @group Resume Sections
     * @authenticated
     * @urlParam resumeId integer required Resume ID. Example: 1
     * @urlParam section string required Section slug. Example: work-experiences
     * @urlParam itemId integer required Item ID. Example: 3
     */
    public function update(Request $request, int $resumeId, string $section, int $itemId): JsonResponse
    {
        $resume = $this->findResume($request, $resumeId);
        $modelClass = $this->resolveSection($section);

        /** @var Model $item */
        $item = $modelClass::where('resume_id', $resume->id)->findOrFail($itemId);

        $data = $request->validate($this->validationRules($section, update: true));

        $item->update($data);

        return response()->json($item);
    }

    /**
     * Delete an item from a resume section.
     *
     * @group Resume Sections
     * @authenticated
     * @urlParam resumeId integer required Resume ID. Example: 1
     * @urlParam section string required Section slug. Example: work-experiences
     * @urlParam itemId integer required Item ID. Example: 3
     */
    public function destroy(Request $request, int $resumeId, string $section, int $itemId): JsonResponse
    {
        $resume = $this->findResume($request, $resumeId);
        $modelClass = $this->resolveSection($section);

        $item = $modelClass::where('resume_id', $resume->id)->findOrFail($itemId);
        $item->delete();

        return response()->json(['message' => 'Item deleted.']);
    }

    private function findResume(Request $request, int $resumeId): Resume
    {
        $user = $request->user();

        if ($user->hasRole(RoleEnum::ADMIN)) {
            return Resume::findOrFail($resumeId);
        }

        return $user->resumes()->findOrFail($resumeId);
    }

    private function resolveSection(string $section): string
    {
        return self::$sectionMap[$section]
            ?? abort(404, "Unknown resume section: {$section}");
    }

    private function validationRules(string $section, bool $update = false): array
    {
        $r = $update ? 'sometimes|' : '';

        return match ($section) {
            'work-experiences' => [
                'job_title'    => $r . 'required|string|max:255',
                'company_name' => $r . 'required|string|max:255',
                'location'     => 'nullable|string|max:255',
                'start_date'   => $r . 'required|date',
                'end_date'     => 'nullable|date|after_or_equal:start_date',
                'is_current'   => 'boolean',
                'description'  => 'nullable|string',
                'sort_order'   => 'integer|min:0',
            ],
            'educations' => [
                'degree'           => $r . 'required|string|max:255',
                'field_of_study'   => $r . 'required|string|max:255',
                'institution_name' => $r . 'required|string|max:255',
                'location'         => 'nullable|string|max:255',
                'graduation_year'  => 'nullable|integer|min:1900|max:2100',
                'gpa'              => 'nullable|numeric|min:0|max:10',
                'sort_order'       => 'integer|min:0',
            ],
            'skills' => [
                'category'    => $r . 'required|string|max:255',
                'name'        => $r . 'required|string|max:255',
                'proficiency' => $r . 'required|in:beginner,intermediate,expert',
                'sort_order'  => 'integer|min:0',
            ],
            'projects' => [
                'name'           => $r . 'required|string|max:255',
                'description'    => 'nullable|string',
                'technologies'   => 'nullable|array',
                'technologies.*' => 'string|max:100',
                'live_url'       => 'nullable|url|max:500',
                'github_url'     => 'nullable|url|max:500',
                'sort_order'     => 'integer|min:0',
            ],
            'certifications' => [
                'name'                 => $r . 'required|string|max:255',
                'issuing_organization' => $r . 'required|string|max:255',
                'issue_date'           => 'nullable|date',
                'sort_order'           => 'integer|min:0',
            ],
            'languages' => [
                'language'    => $r . 'required|string|max:100',
                'proficiency' => $r . 'required|in:native,fluent,conversational,basic',
                'sort_order'  => 'integer|min:0',
            ],
            'awards' => [
                'title'       => $r . 'required|string|max:255',
                'issuer'      => 'nullable|string|max:255',
                'date'        => 'nullable|date',
                'description' => 'nullable|string',
                'sort_order'  => 'integer|min:0',
            ],
            'recommendations' => [
                'full_name'      => $r . 'required|string|max:255',
                'title'          => 'nullable|string|max:255',
                'company'        => 'nullable|string|max:255',
                'email'          => 'nullable|email|max:255',
                'phone'          => 'nullable|string|max:50',
                'recommendation' => 'nullable|string',
                'sort_order'     => 'integer|min:0',
            ],
        };
    }
}
