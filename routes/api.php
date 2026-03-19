<?php

use App\Http\Controllers\AdminThumbnailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ResumeItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SkillCategoryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TaxRateController;
use App\Http\Controllers\UploadTestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Get the authenticated user.
 *
 * @group         Auth
 *
 * @authenticated
 */
Route::middleware('auth:sanctum')->get(
    '/user', function (Request $request) {
        $user = $request->user();
        $user->load('roles');

        return response()->json(
            [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'username'   => $user->username,
                'name'       => $user->name,
                'email'      => $user->email,
                'roles'      => $user->roles->pluck('name'),
            ]
        );
    }
);

/**
 * Get the authenticated user with metadata.
 *
 * @group         Auth
 *
 * @authenticated
 */
Route::middleware('auth:sanctum')->get(
    '/me', function (Request $request) {
        $user = $request->user();
        $user->load('roles');

        return response()->json(
            [
                'user_id' => $user?->id,
                'user'    => [
                    'id'         => $user->id,
                    'first_name' => $user->first_name,
                    'last_name'  => $user->last_name,
                    'username'   => $user->username,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'roles'      => $user->roles->pluck('name'),
                ],
            ]
        );
    }
);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/google', [AuthController::class, 'googleLogin']);
Route::post('/lost-password', [AuthController::class, 'lostPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/check-auth', [AuthController::class, 'checkAuth']);

// Test route
/**
 * Health check.
 *
 * @group Health
 */
Route::get(
    '/hello', function () {
        return 'Hello world from Laravel! This is a test route to check if the API is working.';
    }
);

// Upload test route
Route::post('/upload-test', [UploadTestController::class, 'upload']);

// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Order routes
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/my-orders', [OrderController::class, 'myOrders']);
Route::middleware('auth:sanctum')->get('/my-invoices', [InvoiceController::class, 'myInvoices']);

// Invoice routes
// - Admin & Vendor: full access
// - Customer: read-only, own invoices only (scoped in controller)

Route::get('/invoices/options', [InvoiceController::class, 'options']);

// Public invoice export (no auth, no database save)
Route::post('/invoices/export/pdf', [InvoiceController::class, 'exportPdf']);
Route::post('/invoices/export/html', [InvoiceController::class, 'exportHtml']);
Route::post('/invoices/export/email', [InvoiceController::class, 'exportEmail']);

// Public invoice send (no auth)
Route::post('/invoices/{id}/send', [InvoiceController::class, 'sendEmail']);

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
        Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'pdf']);
        Route::get('/invoices/{id}/html', [InvoiceController::class, 'html']);
        Route::post('/invoices', [InvoiceController::class, 'store'])->middleware('permission:edit_invoices');
        Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->middleware('permission:edit_invoices');
        Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->middleware('permission:delete_invoices');
    }
);

// User routes
Route::get('/users/roles', [UserController::class, 'roles']);
Route::get('/users', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->put('/users/{id}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/users/{id}', [UserController::class, 'destroy']);
Route::patch('/users/update-role', [UserController::class, 'updateRole']);

// Settings routes
Route::get('/settings/languages', [SettingsController::class, 'languages']);
Route::get('/settings/countries', [SettingsController::class, 'countries']);
Route::get('/settings/countries/{code}', [SettingsController::class, 'country']);

// Visitor routes
Route::post('/visitors/track', [VisitorController::class, 'track']);
Route::get('/visitors/today', [VisitorController::class, 'today']);
Route::get('/visitors/total', [VisitorController::class, 'total']);

// Skill category, skill & language lookup routes — public, read-only
Route::get('/skill-categories', [SkillCategoryController::class, 'index']);
Route::get('/skill-categories/{id}/skills', [SkillCategoryController::class, 'skills']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/languages', [LanguageController::class, 'index']);

// Skill category, skill & language management — permission-gated
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/skill-categories', [SkillCategoryController::class, 'store'])->middleware('permission:edit_skill_categories');
    Route::put('/skill-categories/{id}', [SkillCategoryController::class, 'update'])->middleware('permission:edit_skill_categories');
    Route::delete('/skill-categories/{id}', [SkillCategoryController::class, 'destroy'])->middleware('permission:delete_skill_categories');

    Route::post('/skill-categories/{id}/skills', [SkillCategoryController::class, 'storeSkill'])->middleware('permission:edit_skills');
    Route::put('/skill-categories/{id}/skills/{skillId}', [SkillCategoryController::class, 'updateSkill'])->middleware('permission:edit_skills');
    Route::delete('/skill-categories/{id}/skills/{skillId}', [SkillCategoryController::class, 'destroySkill'])->middleware('permission:delete_skills');

    Route::post('/skills', [SkillController::class, 'store'])->middleware('permission:edit_skills');
    Route::put('/skills/{id}', [SkillController::class, 'update'])->middleware('permission:edit_skills');
    Route::delete('/skills/{id}', [SkillController::class, 'destroy'])->middleware('permission:delete_skills');

    Route::post('/languages', [LanguageController::class, 'store'])->middleware('permission:edit_languages');
    Route::put('/languages/{id}', [LanguageController::class, 'update'])->middleware('permission:edit_languages');
    Route::delete('/languages/{id}', [LanguageController::class, 'destroy'])->middleware('permission:delete_languages');
});

// Blog routes — public read, admin write
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{idOrSlug}', [BlogController::class, 'show']);

Route::get('/blog-categories', [BlogCategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/blogs', [BlogController::class, 'adminIndex'])->middleware('permission:view_blogs');
    Route::post('/blogs', [BlogController::class, 'store'])->middleware('permission:edit_blogs');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->middleware('permission:edit_blogs');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->middleware('permission:delete_blogs');

    Route::post('/blog-categories', [BlogCategoryController::class, 'store'])->middleware('permission:edit_blog_categories');
    Route::put('/blog-categories/{id}', [BlogCategoryController::class, 'update'])->middleware('permission:edit_blog_categories');
    Route::delete('/blog-categories/{id}', [BlogCategoryController::class, 'destroy'])->middleware('permission:delete_blog_categories');
});

// Roles & Permissions management — admin only
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::get('/roles/{roleId}/permissions', [PermissionController::class, 'rolePermissions']);
    Route::post('/roles/{roleId}/permissions/assign', [PermissionController::class, 'assign']);
    Route::post('/roles/{roleId}/permissions/revoke', [PermissionController::class, 'revoke']);
    Route::post('/roles/{roleId}/permissions/sync', [PermissionController::class, 'sync']);
});

// Resume routes
$sectionPattern = 'work-experiences|educations|skills|projects|certifications|languages|awards|recommendations';

Route::middleware('signed')->group(function () {
    Route::get('/resumes/{id}/preview/pdf/render', [ResumeController::class, 'signedPreviewPdf'])->name('resume.preview.pdf');
    Route::get('/resumes/{id}/preview/html/render', [ResumeController::class, 'signedPreviewHtml'])->name('resume.preview.html');
});

Route::get('/resumes/export/options', [ResumeController::class, 'exportOptions']);
Route::post('/resumes/export/pdf', [ResumeController::class, 'exportPdfPublic']);
Route::post('/resumes/export/html', [ResumeController::class, 'exportHtmlPublic']);
Route::post('/resumes/preview/pdf', [ResumeController::class, 'previewPdfPublic']);
Route::post('/resumes/preview/html', [ResumeController::class, 'previewHtmlPublic']);
Route::get('/resumes/current', [ResumeController::class, 'current']);
Route::get('/resumes/current/main', [ResumeController::class, 'currentMain']);
Route::get('/resumes/{id}/public', [ResumeController::class, 'showPublic']);

Route::get('/settings/taxrates', [TaxRateController::class, 'index']);
Route::get('/settings/taxrates/{code}', [TaxRateController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () use ($sectionPattern) {
    // Resume CRUD
    Route::get('/resumes', [ResumeController::class, 'index']);
    Route::post('/resumes', [ResumeController::class, 'store']);
    Route::get('/resumes/{id}', [ResumeController::class, 'show']);
    Route::put('/resumes/{id}', [ResumeController::class, 'update']);
    // PHP does not parse multipart/form-data on PUT requests, so file uploads (photo)
    // require POST + _method spoofing. This alias handles that case.
    Route::post('/resumes/{id}', [ResumeController::class, 'update']);
    Route::delete('/resumes/{id}', [ResumeController::class, 'destroy']);
    Route::get('/resumes/{id}/export/pdf', [ResumeController::class, 'exportPdf']);
    Route::get('/resumes/{id}/export/html', [ResumeController::class, 'exportHtml']);
    Route::get('/resumes/{id}/export/json', [ResumeController::class, 'exportJson']);
    Route::get('/resumes/{id}/preview/pdf', [ResumeController::class, 'previewPdf']);
    Route::get('/resumes/{id}/preview/html', [ResumeController::class, 'previewHtml']);
    Route::get('/resumes/{id}/preview/signed-url', [ResumeController::class, 'signedPreviewUrl']);
    Route::post('/resumes/import/json', [ResumeController::class, 'importJson']);
    Route::post('/resumes/{id}/import/json', [ResumeController::class, 'importJson']);

    // Resume section CRUD
    Route::get('/resumes/{resumeId}/{section}', [ResumeItemController::class, 'index'])->where('section', $sectionPattern);
    Route::post('/resumes/{resumeId}/{section}', [ResumeItemController::class, 'store'])->where('section', $sectionPattern);
    Route::put('/resumes/{resumeId}/{section}/{itemId}', [ResumeItemController::class, 'update'])->where('section', $sectionPattern);
    Route::delete('/resumes/{resumeId}/{section}/{itemId}', [ResumeItemController::class, 'destroy'])->where('section', $sectionPattern);

    // Admin – Thumbnail management (admin role enforced in controller)
    Route::post('/admin/thumbnails/regenerate', [AdminThumbnailController::class, 'regenerate']);
    Route::delete('/admin/thumbnails', [AdminThumbnailController::class, 'purge']);
    Route::post('/admin/thumbnails/products/{id}/regenerate', [AdminThumbnailController::class, 'regenerateProduct']);
    Route::delete('/admin/thumbnails/products/{id}', [AdminThumbnailController::class, 'purgeProduct']);
    Route::post('/admin/thumbnails/resumes/{id}/regenerate', [AdminThumbnailController::class, 'regenerateResume']);
    Route::delete('/admin/thumbnails/resumes/{id}', [AdminThumbnailController::class, 'purgeResume']);
});
