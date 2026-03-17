<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Models\Resume;
use App\Models\ResumeAward;
use App\Models\ResumeCertification;
use App\Models\ResumeEducation;
use App\Models\ResumeLanguage;
use App\Models\ResumeProject;
use App\Models\ResumeRecommendation;
use App\Models\ResumeSkill;
use App\Models\ResumeWorkExperience;
use App\Models\User;
use App\Translations\ResumeTranslations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class ResumeController extends Controller
{
    private const THEMES = ['green', 'blue', 'red', 'yellow', 'cyan', 'orange', 'violet', 'black', 'white', 'grey'];

    private const TEMPLATES = ['default'];

    private const LANGUAGES = [
        'en' => 'English',
        'fi' => 'Finnish',
    ];

    /**
     * Display all resumes for the authenticated user.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @queryParam per_page integer Number of results per page (1-100). Defaults to 10. Example: 10
     * @queryParam sort_by string Field to sort by (id, title, created_at, updated_at). Defaults to updated_at. Example: updated_at
     * @queryParam sort_dir string Sort direction (asc, desc). Defaults to desc. Example: desc
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $sortBy       = (string) $request->query('sort_by', 'updated_at');
        $sortDir      = strtolower((string) $request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'title', 'created_at', 'updated_at'];
        $allowedDirs  = ['asc', 'desc'];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'updated_at';
        }
        if (! in_array($sortDir, $allowedDirs, true)) {
            $sortDir = 'desc';
        }

        $user = $request->user();
        $with = ['workExperiences', 'educations', 'skills', 'projects', 'certifications', 'languages', 'awards', 'recommendations'];

        $query = $user->hasRole(RoleEnum::ADMIN)
            ? Resume::with($with)
            : $user->resumes()->with($with);

        $query->orderBy($sortBy, $sortDir);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Display a specific resume with all its sections.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $resume = $this->findResume($request, $id);

        $resume->load(['workExperiences', 'educations', 'skills', 'projects', 'certifications', 'languages', 'awards', 'recommendations']);

        return response()->json($resume);
    }

    /**
     * Create a new resume with all sections in one request.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @bodyParam title string Resume label. Example: "Software Engineer CV"
     * @bodyParam full_name string required Full name. Example: Jussi Palanen
     * @bodyParam email string required Email address. Example: jussi@example.com
     * @bodyParam phone string Phone number. Example: +358401234567
     * @bodyParam location string Location. Example: Helsinki, Finland
     * @bodyParam linkedin_url string LinkedIn profile URL.
     * @bodyParam portfolio_url string Portfolio or website URL.
     * @bodyParam github_url string GitHub profile URL.
     * @bodyParam photo string Path to uploaded professional photo.
     * @bodyParam summary string Professional summary / objective paragraph.
     * @bodyParam work_experiences array Optional work experience entries.
     * @bodyParam educations array Optional education entries.
     * @bodyParam skills array Optional skill entries.
     * @bodyParam skills[].proficiency string Skill level: `beginner` (1), `basic` (2), `intermediate` (3), `advanced` (4), `expert` (5).
     * @bodyParam projects array Optional project entries.
     * @bodyParam certifications array Optional certification entries.
     * @bodyParam languages array Optional language entries.
     * @bodyParam languages[].proficiency string Spoken-language level: `elementary` (1), `limited_working` (2), `professional_working` (3), `full_professional` (4), `native_bilingual` (5).
     * @bodyParam awards array Optional award entries.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'                => 'sometimes|string|max:255',
            'full_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'phone'                => 'nullable|string|max:50',
            'location'             => 'nullable|string|max:255',
            'linkedin_url'         => 'nullable|url|max:500',
            'portfolio_url'        => 'nullable|url|max:500',
            'github_url'           => 'nullable|url|max:500',
            'photo'                => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // max 5MB
            'summary'              => 'nullable|string',
            'language'             => 'sometimes|string|in:en,fi',
            'template'             => 'sometimes|string|in:'.implode(',', self::TEMPLATES),
            'theme'                => 'sometimes|string|in:'.implode(',', self::THEMES),
            'is_primary'           => 'sometimes|boolean',
            'is_public'            => 'sometimes|boolean',
            'code'                 => 'nullable|string|max:100',
            'show_skill_levels'    => 'sometimes|boolean',
            'show_language_levels' => 'sometimes|boolean',
            ...$this->sectionValidationRules(),
        ]);

        $resume = DB::transaction(function () use ($data, $request) {
            $resume = $request->user()->resumes()->create(
                collect($data)->except([...array_keys($this->sectionRelationMap()), 'photo'])->toArray()
            ); // store always creates for the authenticated user

            if (! empty($data['is_primary'])) {
                $this->clearPrimaryForUser($request->user()->id, $resume->id);
            }

            if ($request->hasFile('photo')) {
                $resume->photo       = $this->storeResumePhoto($request->file('photo'), $resume->id);
                $resume->photo_sizes = $this->generateThumbnails($request->file('photo'), $resume->id);
                $resume->save();
            }

            foreach ($this->sectionRelationMap() as $key => $relation) {
                if (! empty($data[$key])) {
                    $resume->$relation()->createMany($data[$key]);
                }
            }

            return $resume;
        });

        $resume->load(array_values($this->sectionRelationMap()));

        return response()->json($resume, 201);
    }

    /**
     * Update a resume and sync provided sections.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @urlParam resume integer required The resume ID. Example: 1
     *
     * @bodyParam skills[].proficiency string Skill level: `beginner` (1), `basic` (2), `intermediate` (3), `advanced` (4), `expert` (5).
     * @bodyParam languages[].proficiency string Spoken-language level: `elementary` (1), `limited_working` (2), `professional_working` (3), `full_professional` (4), `native_bilingual` (5).
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $resume = $this->findResume($request, $id);

        $data = $request->validate([
            'title'                => 'sometimes|string|max:255',
            'full_name'            => 'sometimes|string|max:255',
            'email'                => 'sometimes|email|max:255',
            'phone'                => 'nullable|string|max:50',
            'location'             => 'nullable|string|max:255',
            'linkedin_url'         => 'nullable|url|max:500',
            'portfolio_url'        => 'nullable|url|max:500',
            'github_url'           => 'nullable|url|max:500',
            'photo'                => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // max 5MB
            'summary'              => 'nullable|string',
            'language'             => 'sometimes|string|in:en,fi',
            'template'             => 'sometimes|string|in:'.implode(',', self::TEMPLATES),
            'theme'                => 'sometimes|string|in:'.implode(',', self::THEMES),
            'is_primary'           => 'sometimes|boolean',
            'is_public'            => 'sometimes|boolean',
            'code'                 => 'nullable|string|max:100',
            'show_skill_levels'    => 'sometimes|boolean',
            'show_language_levels' => 'sometimes|boolean',
            ...$this->sectionValidationRules(update: true),
        ]);

        DB::transaction(function () use ($data, $resume, $request) {
            if (! empty($data['is_primary'])) {
                $this->clearPrimaryForUser($request->user()->id, $resume->id);
            }

            $oldPhoto      = $resume->photo;
            $oldPhotoSizes = $resume->photo_sizes;

            $resume->update(
                collect($data)->except([...array_keys($this->sectionRelationMap()), 'photo'])->toArray()
            );

            if ($request->hasFile('photo')) {
                if ($oldPhoto) {
                    Storage::disk($this->storageDiskName())->delete($oldPhoto);
                }
                if ($oldPhotoSizes) {
                    $this->deleteThumbnails($oldPhotoSizes);
                }
                $resume->photo       = $this->storeResumePhoto($request->file('photo'), $resume->id);
                $resume->photo_sizes = $this->generateThumbnails($request->file('photo'), $resume->id);
                $resume->save();
            }

            foreach ($this->sectionRelationMap() as $key => $relation) {
                if (array_key_exists($key, $data)) {
                    $resume->$relation()->delete();
                    if (! empty($data[$key])) {
                        $resume->$relation()->createMany($data[$key]);
                    }
                }
            }
        });

        $resume->load(array_values($this->sectionRelationMap()));

        return response()->json($resume);
    }

    /**
     * Export a resume as a PDF file.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function exportPdf(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        $resume = $this->findResume($request, $id);

        $lang = in_array($request->query('lang'), ['en', 'fi'])
            ? $request->query('lang')
            : (in_array($resume->language, ['en', 'fi']) ? $resume->language : 'en');
        app()->setLocale($lang);
        Carbon::setLocale($lang);

        $resume->load(array_values($this->sectionRelationMap()));

        $theme = in_array($request->query('theme'), self::THEMES)
            ? $request->query('theme')
            : ($resume->theme ?: 'green');

        $template           = $request->query('template', $resume->template ?: 'default');
        $view               = $this->resolveTemplateView($template);
        $showSkillLevels    = $request->has('show_skill_levels')
            ? filter_var($request->query('show_skill_levels'), FILTER_VALIDATE_BOOLEAN)
            : ($resume->show_skill_levels ?? true);
        $showLanguageLevels = $request->has('show_language_levels')
            ? filter_var($request->query('show_language_levels'), FILTER_VALIDATE_BOOLEAN)
            : ($resume->show_language_levels ?? true);

        $filename = str($resume->full_name)->slug().'-resume.pdf';

        if ($view === 'resumes.coming_soon') {
            return response()
                ->view($view, compact('resume', 'theme', 'template'), 200);
        }

        return Pdf::view($view, compact('resume', 'theme', 'showSkillLevels', 'showLanguageLevels'))
            ->format('a4')
            ->margins(0, 0, 0, 0)
            ->withBrowsershot(fn (Browsershot $b) => $b
                ->setChromePath(env('CHROME_PATH', '/usr/bin/chromium-browser'))
                ->noSandbox()
                ->addChromiumArguments(['--disable-gpu'])
            )
            ->download($filename)
            ->toResponse($request);
    }

    /**
     * Export a resume as an HTML file.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function exportHtml(Request $request, int $id): Response
    {
        $resume = $this->findResume($request, $id);

        $lang = in_array($request->query('lang'), ['en', 'fi'])
            ? $request->query('lang')
            : (in_array($resume->language, ['en', 'fi']) ? $resume->language : 'en');
        app()->setLocale($lang);

        $resume->load(array_values($this->sectionRelationMap()));

        $theme = in_array($request->query('theme'), self::THEMES)
            ? $request->query('theme')
            : ($resume->theme ?: 'green');

        $template           = $request->query('template', $resume->template ?: 'default');
        $view               = $this->resolveTemplateView($template);
        $showSkillLevels    = $request->has('show_skill_levels')
            ? filter_var($request->query('show_skill_levels'), FILTER_VALIDATE_BOOLEAN)
            : ($resume->show_skill_levels ?? true);
        $showLanguageLevels = $request->has('show_language_levels')
            ? filter_var($request->query('show_language_levels'), FILTER_VALIDATE_BOOLEAN)
            : ($resume->show_language_levels ?? true);

        $html = view($view, compact('resume', 'theme', 'template', 'showSkillLevels', 'showLanguageLevels'))->render();

        $filename = str($resume->full_name)->slug().'-resume.html';

        return response()->make($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * Export a resume as a downloadable JSON backup file.
     * The photo is not included. All section items are exported without internal IDs.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function exportJson(Request $request, int $id): Response
    {
        $resume = $this->findResume($request, $id);
        $resume->load(array_values($this->sectionRelationMap()));

        $excludeRoot    = ['id', 'user_id', 'photo', 'photo_sizes', 'code', 'created_at', 'updated_at', 'has_code'];
        $excludeSection = ['id', 'resume_id', 'created_at', 'updated_at', 'points'];

        $resumeArray = collect($resume->toArray())->except($excludeRoot)->toArray();

        foreach (array_keys($this->sectionRelationMap()) as $sectionKey) {
            if (isset($resumeArray[$sectionKey]) && is_array($resumeArray[$sectionKey])) {
                $resumeArray[$sectionKey] = array_map(
                    fn ($item) => collect($item)->except($excludeSection)->toArray(),
                    $resumeArray[$sectionKey]
                );
            }
        }

        $payload = [
            'version'     => '1.0',
            'exported_at' => now()->toISOString(),
            'resume'      => $resumeArray,
        ];

        $filename = str($resume->full_name)->slug().'-resume.json';

        return response()->make(
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            200,
            [
                'Content-Type'        => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]
        );
    }

    /**
     * Import a resume from a previously exported JSON backup file.
     * Creates a new resume for the authenticated user. The photo is not restored.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @bodyParam file file required The JSON backup file produced by the export endpoint.
     */
    public function importJson(Request $request, ?int $id = null): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $contents = file_get_contents($request->file('file')->getRealPath());

        try {
            $payload = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return response()->json(['message' => 'The uploaded file is not valid JSON.'], 422);
        }

        if (! isset($payload['resume']) || ! is_array($payload['resume'])) {
            return response()->json(['message' => 'Invalid resume backup file.'], 422);
        }

        // URL parameter takes priority; fall back to id field inside the JSON file.
        $resumeId       = $id ?? (isset($payload['resume']['id']) ? (int) $payload['resume']['id'] : null);
        $existingResume = null;

        if ($resumeId !== null) {
            // findResume enforces ownership: admins may access any resume, users only their own.
            try {
                $existingResume = $this->findResume($request, $resumeId);
            } catch (ModelNotFoundException) {
                return response()->json(['message' => 'Resume not found or access denied.'], 404);
            }
        }

        $isUpdate = $existingResume !== null;

        $validator = Validator::make($payload['resume'], [
            'title'         => 'sometimes|string|max:255',
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'location'      => 'nullable|string|max:255',
            'linkedin_url'  => 'nullable|url|max:500',
            'portfolio_url' => 'nullable|url|max:500',
            'github_url'    => 'nullable|url|max:500',
            'summary'       => 'nullable|string',
            'language'      => 'sometimes|string|in:en,fi',
            'template'      => 'sometimes|string|in:'.implode(',', self::TEMPLATES),
            'theme'         => 'sometimes|string|in:'.implode(',', self::THEMES),
            'is_primary'    => 'sometimes|boolean',
            'is_public'     => 'sometimes|boolean',
            ...$this->sectionValidationRules(update: $isUpdate),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid resume data.', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if ($isUpdate) {
            $resume = DB::transaction(function () use ($data, $existingResume, $request) {
                if (! empty($data['is_primary'])) {
                    $this->clearPrimaryForUser($request->user()->id, $existingResume->id);
                }

                $existingResume->update(
                    collect($data)->except(array_keys($this->sectionRelationMap()))->toArray()
                );

                foreach ($this->sectionRelationMap() as $key => $relation) {
                    if (array_key_exists($key, $data)) {
                        $existingResume->$relation()->delete();
                        if (! empty($data[$key])) {
                            $existingResume->$relation()->createMany($data[$key]);
                        }
                    }
                }

                return $existingResume;
            });

            $resume->load(array_values($this->sectionRelationMap()));

            return response()->json($resume);
        }

        $resume = DB::transaction(function () use ($data, $request) {
            $resume = $request->user()->resumes()->create(
                collect($data)->except(array_keys($this->sectionRelationMap()))->toArray()
            );

            if (! empty($data['is_primary'])) {
                $this->clearPrimaryForUser($request->user()->id, $resume->id);
            }

            foreach ($this->sectionRelationMap() as $key => $relation) {
                if (! empty($data[$key])) {
                    $resume->$relation()->createMany($data[$key]);
                }
            }

            return $resume;
        });

        $resume->load(array_values($this->sectionRelationMap()));

        return response()->json($resume, 201);
    }

    /**
     * Delete a resume and all its sections.
     *
     * @group Resumes
     *
     * @authenticated
     *
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $resume = $this->findResume($request, $id);

        if ($resume->photo) {
            Storage::disk($this->storageDiskName())->delete($resume->photo);
        }

        if ($resume->photo_sizes) {
            $this->deleteThumbnails($resume->photo_sizes);
        }

        $resume->delete();

        return response()->json(['message' => 'Resume deleted.']);
    }

    /**
     * Get the primary resume.
     *
     * Accessible either with a valid Sanctum token (returns the authenticated
     * user's primary resume) or without a token by supplying `owner` (username)
     * query parameter; if the resume has a code set, `code` must also match.
     *
     * @group Resumes
     *
     * @queryParam owner string Username of the resume owner (required for public access). Example: johndoe
     * @queryParam code string Resume access code (required when the resume has one). Example: mycode
     */
    public function current(Request $request): JsonResponse
    {
        $with = array_values($this->sectionRelationMap());

        // Authenticated access: return the current user's primary resume.
        $user = auth('sanctum')->user();
        if ($user) {
            $resume = $user->resumes()->where('is_primary', true)->with($with)->first();

            if (! $resume) {
                return response()->json(['message' => 'No primary resume found.'], 404);
            }

            return response()->json($resume);
        }

        // Public access: owner username required; resume must be public.
        $owner = (string) $request->query('owner', '');
        $code  = (string) $request->query('code', '');

        if (! $owner) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $ownerUser = User::where('username', $owner)->first();

        if (! $ownerUser) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $resume = $ownerUser->resumes()
            ->where('is_primary', true)
            ->where('is_public', true)
            ->with($with)
            ->first();

        if (! $resume) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        if (! empty($resume->getRawOriginal('code')) && $resume->getRawOriginal('code') !== $code) {
            return response()->json(['message' => 'Invalid code.'], 401);
        }

        return response()->json($resume->makeHidden('code'));
    }

    /**
     * Get the main (primary) resume for public display.
     *
     * The resume must be set to public (`is_public = true`).
     * Supports two lookup modes:
     * - By resume ID (`?id=<n>`)
     * - By owner username (`?owner=<username>`)
     *
     * If the resume has a code set, the `code` query parameter must match.
     *
     * @group Resumes
     *
     * @unauthenticated
     *
     * @queryParam id integer Resume ID. Example: 1
     * @queryParam owner string Username of the resume owner. Example: johndoe
     * @queryParam code string Access code (required when the resume has one). Example: mycode
     */
    public function currentMain(Request $request): JsonResponse
    {
        $with  = array_values($this->sectionRelationMap());
        $id    = $request->query('id');
        $owner = (string) $request->query('owner', '');
        $code  = (string) $request->query('code', '');

        // Lookup by resume ID
        if ($id !== null) {
            $resume = Resume::where('id', (int) $id)
                ->where('is_primary', true)
                ->where('is_public', true)
                ->with($with)
                ->first();

            if (! $resume) {
                return response()->json(['message' => 'Resume not found.'], 404);
            }

            if (! empty($resume->getRawOriginal('code')) && $resume->getRawOriginal('code') !== $code) {
                return response()->json(['message' => 'Invalid code.'], 401);
            }

            return response()->json($resume->makeHidden('code'));
        }

        // Lookup by owner username
        if ($owner) {
            $ownerUser = User::where('username', $owner)->first();

            if (! $ownerUser) {
                return response()->json(['message' => 'Resume not found.'], 404);
            }

            $resume = $ownerUser->resumes()
                ->where('is_primary', true)
                ->where('is_public', true)
                ->with($with)
                ->first();

            if (! $resume) {
                return response()->json(['message' => 'Resume not found.'], 404);
            }

            if (! empty($resume->getRawOriginal('code')) && $resume->getRawOriginal('code') !== $code) {
                return response()->json(['message' => 'Invalid code.'], 401);
            }

            return response()->json($resume->makeHidden('code'));
        }

        return response()->json(['message' => 'Provide id or owner.'], 422);
    }

    /**
     * Display a specific public resume (no token required).
     *
     * The resume must be set to public (`is_public = true`).
     * If the resume has a code set, the `code` query parameter must match.
     *
     * @group Resumes
     *
     * @unauthenticated
     *
     * @urlParam id integer required The resume ID. Example: 1
     *
     * @queryParam code string Access code (required when the resume has one). Example: mycode
     */
    public function showPublic(Request $request, int $id): JsonResponse
    {
        $code   = (string) $request->query('code', '');
        $resume = Resume::where('id', $id)
            ->where('is_public', true)
            ->first();

        if (! $resume) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        if (! empty($resume->getRawOriginal('code')) && $resume->getRawOriginal('code') !== $code) {
            return response()->json(['message' => 'Invalid code.'], 401);
        }

        $resume->load(array_values($this->sectionRelationMap()));

        return response()->json($resume->makeHidden('code'));
    }

    private function clearPrimaryForUser(int $userId, int $exceptResumeId): void
    {
        Resume::where('user_id', $userId)
            ->where('id', '!=', $exceptResumeId)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
    }

    private function storageDiskName(): string
    {
        return (string) config('filesystems.default');
    }

    /**
     * Export a resume as a PDF from a JSON payload (no stored resume required).
     * The photo can be supplied as a base64-encoded string in `photo`.
     * The result is identical to the authenticated export but nothing is written to the database.
     *
     * @group Resumes
     *
     * @unauthenticated
     */
    public function exportPdfPublic(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $data = $this->validatePublicExportPayload($request);

        $lang = in_array($data['language'] ?? null, ['en', 'fi']) ? $data['language'] : 'en';
        app()->setLocale($lang);
        Carbon::setLocale($lang);

        $resume             = $this->buildResumeFromPayload($data);
        $theme              = in_array($data['theme'] ?? null, self::THEMES) ? $data['theme'] : 'green';
        $template           = $data['template'] ?? 'default';
        $view               = $this->resolveTemplateView($template);
        $photoDataUri       = $this->decodePhotoBase64($data['photo'] ?? null);
        $showSkillLevels    = (bool) ($data['show_skill_levels'] ?? true);
        $showLanguageLevels = (bool) ($data['show_language_levels'] ?? true);
        $filename           = str($resume->full_name)->slug().'-resume.pdf';

        if ($view === 'resumes.coming_soon') {
            return response()->view(
                $view,
                compact('resume', 'theme', 'template', 'photoDataUri'),
                200
            );
        }

        return Pdf::view($view, compact('resume', 'theme', 'photoDataUri', 'showSkillLevels', 'showLanguageLevels'))
            ->format('a4')
            ->margins(0, 0, 0, 0)
            ->withBrowsershot(fn (Browsershot $b) => $b
                ->setChromePath(env('CHROME_PATH', '/usr/bin/chromium-browser'))
                ->noSandbox()
                ->addChromiumArguments(['--disable-gpu'])
            )
            ->download($filename)
            ->toResponse($request);
    }

    /**
     * Export a resume as an HTML file from a JSON payload (no stored resume required).
     * The photo can be supplied as a base64-encoded string in `photo`.
     *
     * @group Resumes
     *
     * @unauthenticated
     */
    public function exportHtmlPublic(Request $request): Response
    {
        $data = $this->validatePublicExportPayload($request);

        $lang = in_array($data['language'] ?? null, ['en', 'fi']) ? $data['language'] : 'en';
        app()->setLocale($lang);
        Carbon::setLocale($lang);

        $resume             = $this->buildResumeFromPayload($data);
        $theme              = in_array($data['theme'] ?? null, self::THEMES) ? $data['theme'] : 'green';
        $template           = $data['template'] ?? 'default';
        $view               = $this->resolveTemplateView($template);
        $photoDataUri       = $this->decodePhotoBase64($data['photo'] ?? null);
        $showSkillLevels    = (bool) ($data['show_skill_levels'] ?? true);
        $showLanguageLevels = (bool) ($data['show_language_levels'] ?? true);

        $html     = view($view, compact('resume', 'theme', 'template', 'photoDataUri', 'showSkillLevels', 'showLanguageLevels'))->render();
        $filename = str($resume->full_name)->slug().'-resume.html';

        return response()->make($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * Return available themes, templates, and languages for PDF/HTML export.
     * Pass `?lang=fi` to receive translated labels (default: `en`).
     *
     * @group Resumes
     *
     * @unauthenticated
     */
    public function exportOptions(Request $request): JsonResponse
    {
        $lang = in_array($request->query('lang'), array_keys(self::LANGUAGES), true)
            ? $request->query('lang')
            : 'en';

        return response()->json([
            'themes'                 => ResumeTranslations::themes(self::THEMES, $lang),
            'templates'              => ResumeTranslations::templates(self::TEMPLATES, $lang),
            'languages'              => ResumeTranslations::languages(self::LANGUAGES, $lang),
            'skill_categories'       => ResumeTranslations::skillCategories($lang),
            'skill_proficiencies'    => ResumeTranslations::skillProficiencies($lang),
            'language_proficiencies' => ResumeTranslations::languageProficiencies($lang),
            'spoken_languages'       => ResumeTranslations::spokenLanguages($lang),
        ]);
    }

    private function validatePublicExportPayload(Request $request): array
    {
        return $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'location'      => 'nullable|string|max:255',
            'linkedin_url'  => 'nullable|url|max:500',
            'portfolio_url' => 'nullable|url|max:500',
            'github_url'    => 'nullable|url|max:500',
            'title'         => 'nullable|string|max:255',
            'summary'       => 'nullable|string',
            'language'      => 'sometimes|string|in:en,fi',
            'template'      => 'sometimes|string|in:'.implode(',', self::TEMPLATES),
            'theme'         => 'sometimes|string|in:'.implode(',', self::THEMES),
            // Base64-encoded image, max ~5 MB decoded (≈6.7 MB as base64 text)
            'photo'                => 'nullable|string|max:7000000',
            'show_skill_levels'    => 'sometimes|boolean',
            'show_language_levels' => 'sometimes|boolean',
            ...$this->sectionValidationRules(),
        ]);
    }

    /**
     * Build an unsaved Resume model (with relations set as in-memory collections)
     * from validated payload data. Nothing is written to the database.
     */
    private function buildResumeFromPayload(array $data): Resume
    {
        $resume = (new Resume)->forceFill(
            collect($data)->only([
                'title', 'full_name', 'email', 'phone', 'location',
                'linkedin_url', 'portfolio_url', 'github_url', 'summary',
                'language', 'template', 'theme',
            ])->toArray()
        );

        $sectionModelMap = [
            'work_experiences' => [ResumeWorkExperience::class, 'workExperiences'],
            'educations'       => [ResumeEducation::class,      'educations'],
            'skills'           => [ResumeSkill::class,          'skills'],
            'projects'         => [ResumeProject::class,        'projects'],
            'certifications'   => [ResumeCertification::class,  'certifications'],
            'languages'        => [ResumeLanguage::class,       'languages'],
            'awards'           => [ResumeAward::class,          'awards'],
            'recommendations'  => [ResumeRecommendation::class, 'recommendations'],
        ];

        foreach ($sectionModelMap as $key => [$modelClass, $relation]) {
            $items = collect($data[$key] ?? [])
                ->map(fn ($item) => (new $modelClass)->forceFill($item));
            $resume->setRelation($relation, $items);
        }

        return $resume;
    }

    /**
     * Decode a base64 photo string (with or without a data URI prefix) and
     * return a safe data URI, or null if the input is absent or invalid.
     * Only JPEG, PNG, GIF, and WebP are accepted (validated via magic bytes).
     */
    private function decodePhotoBase64(?string $base64): ?string
    {
        if (! $base64) {
            return null;
        }

        // Strip data URI prefix if the caller included it (e.g. "data:image/jpeg;base64,...")
        if (str_contains($base64, ',')) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
        }

        $decoded = base64_decode(trim($base64), strict: true);
        if ($decoded === false || strlen($decoded) < 8) {
            return null;
        }

        // Derive MIME type from magic bytes — never trust the caller's declared type
        $mime = match (true) {
            str_starts_with($decoded, "\xFF\xD8\xFF")                              => 'image/jpeg',
            str_starts_with($decoded, "\x89PNG")                                   => 'image/png',
            str_starts_with($decoded, 'GIF8')                                      => 'image/gif',
            str_starts_with($decoded, 'RIFF') && substr($decoded, 8, 4) === 'WEBP' => 'image/webp',
            default                                                                => null,
        };

        if (! $mime) {
            return null;
        }

        return 'data:'.$mime.';base64,'.base64_encode($decoded);
    }

    /**
     * Resolve the Blade view name for a given template slug.
     * Known templates map to their view; anything unrecognised → coming_soon.
     */
    private function resolveTemplateView(string $template): string
    {
        return match ($template) {
            'default' => 'resumes.pdf',
            default   => 'resumes.coming_soon',
        };
    }

    /**
     * Thumbnail size presets: [ name => [width, height] ]
     *
     * - thumb  (80×80)   – tiny avatar / list icons
     * - small  (200×200) – UI preview cards / resume sidebar
     * - medium (400×400) – PDF & HTML export
     */
    private function photoSizes(): array
    {
        return [
            'thumb'  => [80,  80],
            'small'  => [200, 200],
            'medium' => [400, 400],
        ];
    }

    private function storeResumePhoto(UploadedFile $file, int $resumeId): string
    {
        $filename = time().'_'.$file->getClientOriginalName();

        return $file->storeAs("resumes/{$resumeId}", $filename, $this->storageDiskName());
    }

    private function generateThumbnails(UploadedFile $file, int $resumeId): array
    {
        $manager = new ImageManager(new Driver);
        $disk    = Storage::disk($this->storageDiskName());
        $base    = time();
        $ext     = 'jpg';
        $paths   = [];

        foreach ($this->photoSizes() as $name => [$w, $h]) {
            $encoded = $manager->read($file->getPathname())
                ->cover($w, $h)
                ->toJpeg(85);

            $path = "resumes/{$resumeId}/{$base}_{$name}.{$ext}";
            $disk->put($path, (string) $encoded);
            $paths[$name] = $path;
        }

        return $paths;
    }

    private function deleteThumbnails(array $photoSizes): void
    {
        $disk = Storage::disk($this->storageDiskName());

        foreach ($photoSizes as $path) {
            if ($path) {
                $disk->delete($path);
            }
        }
    }

    private function findResume(Request $request, int $id): Resume
    {
        $user = $request->user();

        if ($user->hasRole(RoleEnum::ADMIN)) {
            return Resume::findOrFail($id);
        }

        return $user->resumes()->findOrFail($id);
    }

    private function sectionRelationMap(): array
    {
        return [
            'work_experiences' => 'workExperiences',
            'educations'       => 'educations',
            'skills'           => 'skills',
            'projects'         => 'projects',
            'certifications'   => 'certifications',
            'languages'        => 'languages',
            'awards'           => 'awards',
            'recommendations'  => 'recommendations',
        ];
    }

    private function sectionValidationRules(bool $update = false): array
    {
        $r = $update ? 'sometimes|' : '';

        return [
            'work_experiences'                => 'sometimes|array',
            'work_experiences.*.job_title'    => $r.'required|string|max:255',
            'work_experiences.*.company_name' => $r.'required|string|max:255',
            'work_experiences.*.location'     => 'nullable|string|max:255',
            'work_experiences.*.start_date'   => $r.'required|date',
            'work_experiences.*.end_date'     => 'nullable|date|after_or_equal:work_experiences.*.start_date',
            'work_experiences.*.is_current'   => 'boolean',
            'work_experiences.*.description'  => 'nullable|string',
            'work_experiences.*.sort_order'   => 'integer|min:0',

            'educations'                    => 'sometimes|array',
            'educations.*.degree'           => $r.'required|string|max:255',
            'educations.*.field_of_study'   => $r.'required|string|max:255',
            'educations.*.institution_name' => $r.'required|string|max:255',
            'educations.*.location'         => 'nullable|string|max:255',
            'educations.*.graduation_year'  => 'nullable|integer|min:1900|max:2100',
            'educations.*.gpa'              => 'nullable|numeric|min:0|max:10',
            'educations.*.sort_order'       => 'integer|min:0',

            'skills'               => 'sometimes|array',
            'skills.*.category'    => [$r.'required', Rule::in(ResumeSkill::CATEGORIES)],
            'skills.*.name'        => $r.'required|string|max:255',
            'skills.*.proficiency' => [$r.'required', Rule::in(ResumeSkill::PROFICIENCY_LEVELS)],
            'skills.*.sort_order'  => 'integer|min:0',

            'projects'                  => 'sometimes|array',
            'projects.*.name'           => $r.'required|string|max:255',
            'projects.*.description'    => 'nullable|string',
            'projects.*.technologies'   => 'nullable|array',
            'projects.*.technologies.*' => 'string|max:100',
            'projects.*.live_url'       => 'nullable|url|max:500',
            'projects.*.github_url'     => 'nullable|url|max:500',
            'projects.*.sort_order'     => 'integer|min:0',

            'certifications'                        => 'sometimes|array',
            'certifications.*.name'                 => $r.'required|string|max:255',
            'certifications.*.issuing_organization' => $r.'required|string|max:255',
            'certifications.*.issue_date'           => 'nullable|date',
            'certifications.*.sort_order'           => 'integer|min:0',

            'languages'               => 'sometimes|array',
            'languages.*.language'    => $r.'required|string|max:100',
            'languages.*.proficiency' => [$r.'required', Rule::in(ResumeLanguage::PROFICIENCY_LEVELS)],
            'languages.*.sort_order'  => 'integer|min:0',

            'awards'               => 'sometimes|array',
            'awards.*.title'       => $r.'required|string|max:255',
            'awards.*.issuer'      => 'nullable|string|max:255',
            'awards.*.date'        => 'nullable|date',
            'awards.*.description' => 'nullable|string',
            'awards.*.sort_order'  => 'integer|min:0',

            'recommendations'                  => 'sometimes|array',
            'recommendations.*.full_name'      => $r.'required|string|max:255',
            'recommendations.*.title'          => 'nullable|string|max:255',
            'recommendations.*.company'        => 'nullable|string|max:255',
            'recommendations.*.email'          => 'nullable|email|max:255',
            'recommendations.*.phone'          => 'nullable|string|max:50',
            'recommendations.*.recommendation' => 'nullable|string',
            'recommendations.*.sort_order'     => 'integer|min:0',
        ];
    }
}
