<?php

namespace App\Http\Controllers;

use App\Enums\Role as RoleEnum;
use App\Models\Product;
use App\Models\Resume;
use App\Services\ThumbnailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminThumbnailController extends Controller
{
    public function __construct(private readonly ThumbnailService $service) {}

    /**
     * Regenerate thumbnail images for products and/or resumes.
     *
     * @group Admin – Thumbnails
     * @authenticated
     * @queryParam type string Which model to process: products, resumes, or all (default). Example: all
     */
    public function regenerate(Request $request): JsonResponse
    {
        if (!$this->isAdmin($request)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $type = strtolower((string) $request->query('type', 'all'));

        if (!in_array($type, ['all', 'products', 'resumes'], true)) {
            return response()->json(['message' => 'Invalid type. Use: products, resumes, or all.'], 422);
        }

        $results = [];

        if (in_array($type, ['all', 'resumes'], true)) {
            $results['resumes'] = $this->service->regenerateResumes();
        }

        if (in_array($type, ['all', 'products'], true)) {
            $results['products'] = $this->service->regenerateProducts();
        }

        return response()->json(['message' => 'Thumbnails regenerated.', 'results' => $results]);
    }

    /**
     * Delete all thumbnail images for products and/or resumes (originals are kept).
     *
     * @group Admin – Thumbnails
     * @authenticated
     * @queryParam type string Which model to purge: products, resumes, or all (default). Example: all
     */
    public function purge(Request $request): JsonResponse
    {
        if (!$this->isAdmin($request)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $type = strtolower((string) $request->query('type', 'all'));

        if (!in_array($type, ['all', 'products', 'resumes'], true)) {
            return response()->json(['message' => 'Invalid type. Use: products, resumes, or all.'], 422);
        }

        $results = [];

        if (in_array($type, ['all', 'resumes'], true)) {
            $results['resumes'] = $this->service->purgeResumeThumbnails();
        }

        if (in_array($type, ['all', 'products'], true)) {
            $results['products'] = $this->service->purgeProductThumbnails();
        }

        return response()->json(['message' => 'Thumbnails purged.', 'results' => $results]);
    }

    private function isAdmin(Request $request): bool
    {
        $user = $request->user();
        return $user !== null && $user->hasRole(RoleEnum::ADMIN);
    }

    /**
     * Regenerate thumbnails for a single product.
     *
     * @group Admin – Thumbnails
     * @authenticated
     * @urlParam id integer required Product ID. Example: 1
     */
    public function regenerateProduct(Request $request, int $id): JsonResponse
    {
        if (!$this->isAdmin($request)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $result = $this->service->regenerateProducts($product);

        return response()->json(['message' => "Thumbnails regenerated for product #{$id}.", 'result' => $result]);
    }

    /**
     * Purge thumbnails for a single product.
     *
     * @group Admin – Thumbnails
     * @authenticated
     * @urlParam id integer required Product ID. Example: 1
     */
    public function purgeProduct(Request $request, int $id): JsonResponse
    {
        if (!$this->isAdmin($request)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $result = $this->service->purgeProductThumbnails($product);

        return response()->json(['message' => "Thumbnails purged for product #{$id}.", 'result' => $result]);
    }

    /**
     * Regenerate thumbnails for a single resume.
     *
     * @group Admin – Thumbnails
     * @authenticated
     * @urlParam id integer required Resume ID. Example: 1
     */
    public function regenerateResume(Request $request, int $id): JsonResponse
    {
        if (!$this->isAdmin($request)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $resume = Resume::find($id);
        if (!$resume) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $result = $this->service->regenerateResumes($resume);

        return response()->json(['message' => "Thumbnails regenerated for resume #{$id}.", 'result' => $result]);
    }

    /**
     * Purge thumbnails for a single resume.
     *
     * @group Admin – Thumbnails
     * @authenticated
     * @urlParam id integer required Resume ID. Example: 1
     */
    public function purgeResume(Request $request, int $id): JsonResponse
    {
        if (!$this->isAdmin($request)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $resume = Resume::find($id);
        if (!$resume) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $result = $this->service->purgeResumeThumbnails($resume);

        return response()->json(['message' => "Thumbnails purged for resume #{$id}.", 'result' => $result]);
    }
}
