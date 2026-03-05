<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * List products.
     *
     * @group Products
     * @queryParam per_page integer Items per page. Example: 25
     * @queryParam page integer Page number. Example: 2
     * @queryParam search string Search by title or description. Example: headphones
     * @queryParam ids string Comma-separated product IDs. Example: 1,2,3
     * @queryParam sort_by string Sort field. Example: created_at
     * @queryParam sort_dir string Sort direction. Example: desc
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $sortBy = (string) $request->query('sort_by', 'created_at');
        $sortDir = strtolower((string) $request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'title', 'price', 'sale_price', 'quantity', 'created_at', 'updated_at'];
        $allowedDirs = ['asc', 'desc'];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortDir, $allowedDirs, true)) {
            $sortDir = 'desc';
        }

        $search = trim((string) $request->query('search', ''));
        $idsParam = (string) $request->query('ids', '');
        $query = Product::query();

        if ($idsParam !== '') {
            $ids = array_values(array_filter(array_map('intval', array_map('trim', explode(',', $idsParam)))));
            if ($ids !== []) {
                $query->whereIn('id', $ids);
            }
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sortBy, $sortDir);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Create a product.
     *
     * @group Products
     * @bodyParam id integer Optional custom ID. Example: 1001
     * @bodyParam title string required Product title. Example: Wireless Headphones
     * @bodyParam description string Product description. Example: Premium noise-cancelling headphones
     * @bodyParam price number required Price. Example: 299.99
     * @bodyParam sale_price number Sale price. Example: 249.99
     * @bodyParam quantity integer Quantity in stock. Example: 50
     * @bodyParam visibility boolean Visibility flag. Example: true
     * @bodyParam featured_image file Featured image file.
     * @bodyParam images[] file Additional image files.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'sometimes|integer|unique:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'images.*' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'visibility' => 'nullable|boolean',
        ]);

        // Validate max 15 images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageCount = is_array($images) ? count($images) : 1;
            if ($imageCount > 15) {
                return response()->json(['message' => 'Maximum 15 images allowed'], 422);
            }
        }

        // Create product first to get ID
        $product = Product::create([
            'id' => $data['id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'quantity' => $data['quantity'] ?? null,
            'visibility' => $data['visibility'] ?? null,
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs("products/{$product->id}", $filename, 'public');
            $product->featured_image = $path;
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            $images = $request->file('images');
            // Ensure images is an array
            if (!is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $filename = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs("products/{$product->id}", $filename, 'public');
                $imagePaths[] = $path;
            }
            $product->images = $imagePaths;
        }

        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Get a product.
     *
     * @group Products
     * @urlParam id integer required Product ID. Example: 1
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    /**
     * Update a product.
     *
     * @group Products
     * @urlParam id integer required Product ID. Example: 1
     * @bodyParam title string Product title. Example: Wireless Headphones
     * @bodyParam description string Product description. Example: Premium noise-cancelling headphones
     * @bodyParam price number Price. Example: 299.99
     * @bodyParam sale_price number Sale price. Example: 249.99
     * @bodyParam quantity integer Quantity in stock. Example: 50
     * @bodyParam visibility boolean Visibility flag. Example: true
     * @bodyParam featured_image file Featured image file.
     * @bodyParam images[] file Additional image files.
     * @bodyParam delete_images[] string Image paths to delete. Example: products/1/image.png
     * @bodyParam delete_featured_image boolean Delete featured image. Example: false
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'images.*' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'visibility' => 'nullable|boolean',
            'delete_images' => 'sometimes|array',
            'delete_images.*' => 'string',
            'delete_featured_image' => 'sometimes|boolean',
        ]);

        $deleteImages = $data['delete_images'] ?? [];
        if ($deleteImages !== []) {
            $normalizedPaths = [];
            foreach ($deleteImages as $value) {
                $value = trim((string) $value);
                if ($value === '') {
                    continue;
                }

                if (str_starts_with($value, "products/{$product->id}/")) {
                    $path = $value;
                } else {
                    $path = "products/{$product->id}/{$value}";
                }

                if (str_starts_with($path, "products/{$product->id}/")) {
                    $normalizedPaths[] = $path;
                }
            }

            $normalizedPaths = array_values(array_unique($normalizedPaths));
            if ($normalizedPaths !== []) {
                Storage::disk('public')->delete($normalizedPaths);
                if (is_array($product->images)) {
                    $product->images = array_values(array_filter(
                        $product->images,
                        fn ($path) => !in_array($path, $normalizedPaths, true)
                    ));
                }
            }
        }

        if ($request->boolean('delete_featured_image') && $product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
            $product->featured_image = null;
        }

        // Validate max 15 total images (existing + new)
        $existingCount = is_array($product->images) ? count($product->images) : 0;
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $newCount = is_array($images) ? count($images) : 1;
            if ($existingCount + $newCount > 15) {
                return response()->json(['message' => 'Maximum 15 images allowed in total'], 422);
            }
        }

        // Update basic fields
        $product->fill([
            'title' => $data['title'] ?? $product->title,
            'description' => $data['description'] ?? $product->description,
            'price' => $data['price'] ?? $product->price,
            'sale_price' => $data['sale_price'] ?? $product->sale_price,
            'quantity' => $data['quantity'] ?? $product->quantity,
            'visibility' => $data['visibility'] ?? $product->visibility,
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs("products/{$product->id}", $filename, 'public');
            $product->featured_image = $path;
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = $product->images ?? [];
            $images = $request->file('images');
            // Ensure images is an array
            if (!is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $filename = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs("products/{$product->id}", $filename, 'public');
                $imagePaths[] = $path;
            }
            $product->images = $imagePaths;
        }

        $product->save();

        return response()->json($product);
    }

    /**
     * Delete a product.
     *
     * @group Products
     * @urlParam id integer required Product ID. Example: 1
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $pathsToDelete = [];
        if ($product->featured_image) {
            $pathsToDelete[] = $product->featured_image;
        }
        if (is_array($product->images)) {
            $pathsToDelete = array_merge($pathsToDelete, $product->images);
        }
        $pathsToDelete = array_values(array_unique(array_filter($pathsToDelete)));
        if ($pathsToDelete !== []) {
            Storage::disk('public')->delete($pathsToDelete);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}