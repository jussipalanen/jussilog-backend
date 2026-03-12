<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Models\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ResumeController extends Controller
{
    /**
     * Display all resumes for the authenticated user.
     *
     * @group Resumes
     * @authenticated
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $with = ['workExperiences', 'educations', 'skills', 'projects', 'certifications', 'languages', 'awards', 'recommendations'];

        $query = $user->hasRole(RoleEnum::ADMIN)
            ? Resume::with($with)
            : $user->resumes()->with($with);

        $resumes = $query->orderByDesc('updated_at')->get();

        return response()->json($resumes);
    }

    /**
     * Display a specific resume with all its sections.
     *
     * @group Resumes
     * @authenticated
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
     * @authenticated
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
     * @bodyParam projects array Optional project entries.
     * @bodyParam certifications array Optional certification entries.
     * @bodyParam languages array Optional language entries.
     * @bodyParam awards array Optional award entries.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'         => 'sometimes|string|max:255',
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'location'      => 'nullable|string|max:255',
            'linkedin_url'  => 'nullable|url|max:500',
            'portfolio_url' => 'nullable|url|max:500',
            'github_url'    => 'nullable|url|max:500',
            'photo'    => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // max 5MB
            'summary'       => 'nullable|string',
            'language'      => 'sometimes|string|in:en,fi',
            ...$this->sectionValidationRules(),
        ]);

        $resume = DB::transaction(function () use ($data, $request) {
            $resume = $request->user()->resumes()->create(
                collect($data)->except([...array_keys($this->sectionRelationMap()), 'photo'])->toArray()
            ); // store always creates for the authenticated user

            if ($request->hasFile('photo')) {
                $resume->photo = $this->storeResumePhoto($request->file('photo'), $resume->id);
                $resume->photo_sizes = $this->generateThumbnails($request->file('photo'), $resume->id);
                $resume->save();
            }

            foreach ($this->sectionRelationMap() as $key => $relation) {
                if (!empty($data[$key])) {
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
     * @authenticated
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $resume = $this->findResume($request, $id);

        $data = $request->validate([
            'title'         => 'sometimes|string|max:255',
            'full_name'     => 'sometimes|string|max:255',
            'email'         => 'sometimes|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'location'      => 'nullable|string|max:255',
            'linkedin_url'  => 'nullable|url|max:500',
            'portfolio_url' => 'nullable|url|max:500',
            'github_url'    => 'nullable|url|max:500',
            'photo'         => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // max 5MB
            'summary'       => 'nullable|string',
            'language'      => 'sometimes|string|in:en,fi',
            ...$this->sectionValidationRules(update: true),
        ]);

        DB::transaction(function () use ($data, $resume, $request) {
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
                $resume->photo = $this->storeResumePhoto($request->file('photo'), $resume->id);
                $resume->photo_sizes = $this->generateThumbnails($request->file('photo'), $resume->id);
                $resume->save();
            }

            foreach ($this->sectionRelationMap() as $key => $relation) {
                if (array_key_exists($key, $data)) {
                    $resume->$relation()->delete();
                    if (!empty($data[$key])) {
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
     * @authenticated
     * @urlParam resume integer required The resume ID. Example: 1
     */
    public function exportPdf(Request $request, int $id): Response
    {
        $resume = $this->findResume($request, $id);

        $lang = in_array($request->query('lang'), ['en', 'fi'])
            ? $request->query('lang')
            : (in_array($resume->language, ['en', 'fi']) ? $resume->language : 'en');
        app()->setLocale($lang);

        $resume->load(array_values($this->sectionRelationMap()));

        $pdf = Pdf::loadView('resumes.pdf', compact('resume'))
            ->setPaper('a4', 'portrait');

        $filename = str($resume->full_name)->slug() . '-resume.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export a resume as an HTML file.
     *
     * @group Resumes
     * @authenticated
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

        $html = view('resumes.pdf', compact('resume'))->render();

        $filename = str($resume->full_name)->slug() . '-resume.html';

        return response()->make($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Delete a resume and all its sections.
     *
     * @group Resumes
     * @authenticated
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

    private function storageDiskName(): string
    {
        return (string) config('filesystems.default');
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
        $filename = time() . '_' . $file->getClientOriginalName();

        return $file->storeAs("resumes/{$resumeId}", $filename, $this->storageDiskName());
    }

    private function generateThumbnails(UploadedFile $file, int $resumeId): array
    {
        $manager = new ImageManager(new Driver());
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
            'work_experiences.*.job_title'    => $r . 'required|string|max:255',
            'work_experiences.*.company_name' => $r . 'required|string|max:255',
            'work_experiences.*.location'     => 'nullable|string|max:255',
            'work_experiences.*.start_date'   => $r . 'required|date',
            'work_experiences.*.end_date'     => 'nullable|date|after_or_equal:work_experiences.*.start_date',
            'work_experiences.*.is_current'   => 'boolean',
            'work_experiences.*.description'  => 'nullable|string',
            'work_experiences.*.sort_order'   => 'integer|min:0',

            'educations'                          => 'sometimes|array',
            'educations.*.degree'                 => $r . 'required|string|max:255',
            'educations.*.field_of_study'         => $r . 'required|string|max:255',
            'educations.*.institution_name'       => $r . 'required|string|max:255',
            'educations.*.location'               => 'nullable|string|max:255',
            'educations.*.graduation_year'        => 'nullable|integer|min:1900|max:2100',
            'educations.*.gpa'                    => 'nullable|numeric|min:0|max:10',
            'educations.*.sort_order'             => 'integer|min:0',

            'skills'                  => 'sometimes|array',
            'skills.*.category'       => $r . 'required|string|max:255',
            'skills.*.name'           => $r . 'required|string|max:255',
            'skills.*.proficiency'    => $r . 'required|in:beginner,intermediate,expert',
            'skills.*.sort_order'     => 'integer|min:0',

            'projects'                    => 'sometimes|array',
            'projects.*.name'             => $r . 'required|string|max:255',
            'projects.*.description'      => 'nullable|string',
            'projects.*.technologies'     => 'nullable|array',
            'projects.*.technologies.*'   => 'string|max:100',
            'projects.*.live_url'         => 'nullable|url|max:500',
            'projects.*.github_url'       => 'nullable|url|max:500',
            'projects.*.sort_order'       => 'integer|min:0',

            'certifications'                          => 'sometimes|array',
            'certifications.*.name'                   => $r . 'required|string|max:255',
            'certifications.*.issuing_organization'   => $r . 'required|string|max:255',
            'certifications.*.issue_date'             => 'nullable|date',
            'certifications.*.sort_order'             => 'integer|min:0',

            'languages'                   => 'sometimes|array',
            'languages.*.language'        => $r . 'required|string|max:100',
            'languages.*.proficiency'     => $r . 'required|in:native,fluent,conversational,basic',
            'languages.*.sort_order'      => 'integer|min:0',

            'awards'                  => 'sometimes|array',
            'awards.*.title'          => $r . 'required|string|max:255',
            'awards.*.issuer'         => 'nullable|string|max:255',
            'awards.*.date'           => 'nullable|date',
            'awards.*.description'    => 'nullable|string',
            'awards.*.sort_order'     => 'integer|min:0',

            'recommendations'                      => 'sometimes|array',
            'recommendations.*.full_name'          => $r . 'required|string|max:255',
            'recommendations.*.title'              => 'nullable|string|max:255',
            'recommendations.*.company'            => 'nullable|string|max:255',
            'recommendations.*.email'              => 'nullable|email|max:255',
            'recommendations.*.phone'              => 'nullable|string|max:50',
            'recommendations.*.recommendation'     => 'nullable|string',
            'recommendations.*.sort_order'         => 'integer|min:0',
        ];
    }
}
