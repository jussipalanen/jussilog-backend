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
     *
     * Skill proficiency levels (section: skills):
     * - 1 `beginner`      — Just starting out
     * - 2 `basic`         — Can handle simple tasks
     * - 3 `intermediate`  — Works independently on common tasks
     * - 4 `advanced`      — Handles complex scenarios confidently
     * - 5 `expert`        — Deep mastery
     *
     * Spoken-language proficiency levels (section: languages):
     * - 1 `elementary`             — Basic words and phrases
     * - 2 `limited_working`        — Can handle routine communication
     * - 3 `professional_working`   — Effective in most work situations
     * - 4 `full_professional`      — Precise in demanding contexts
     * - 5 `native_bilingual`       — Native or bilingual fluency
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
     *
     * Skill proficiency levels (section: skills):
     * - 1 `beginner`      — Just starting out
     * - 2 `basic`         — Can handle simple tasks
     * - 3 `intermediate`  — Works independently on common tasks
     * - 4 `advanced`      — Handles complex scenarios confidently
     * - 5 `expert`        — Deep mastery
     *
     * Spoken-language proficiency levels (section: languages):
     * - 1 `elementary`             — Basic words and phrases
     * - 2 `limited_working`        — Can handle routine communication
     * - 3 `professional_working`   — Effective in most work situations
     * - 4 `full_professional`      — Precise in demanding contexts
     * - 5 `native_bilingual`       — Native or bilingual fluency
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
                'category'    => $r . 'required|in:programming_languages,scripting_languages,markup_languages,query_languages,frontend_technologies,backend_technologies,full_stack_development,frameworks,libraries,ui_ux_design,responsive_design,mobile_development,desktop_development,game_development,embedded_systems,databases,database_design,database_administration,orm_data_access,api_development,web_services,graphql,microservices,event_driven_architecture,devops,cloud_platforms,serverless,containerization,ci_cd,infrastructure_as_code,configuration_management,version_control,testing_qa,test_automation,security,authentication_authorization,networking,performance_optimization,architecture_design_patterns,system_design,distributed_systems,data_engineering,big_data,machine_learning_ai,monitoring_logging,development_tools,operating_systems,project_management,agile_methodologies,soft_skills,other',
                'name'        => $r . 'required|string|max:255',
                'proficiency' => $r . 'required|in:beginner,basic,intermediate,advanced,expert',
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
                'proficiency' => $r . 'required|in:native_bilingual,full_professional,professional_working,limited_working,elementary',
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
