<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadTestController extends Controller
{
    /**
     * Upload test file.
     *
     * @group Uploads
     *
     * @bodyParam file file required Image file to upload.
     */
    public function upload(Request $request): JsonResponse
    {
        $data = $request->validate([
            'file' => 'required|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        $path = $this->storageDisk()->putFile('upload-test', $data['file']);
        $url  = $this->resolveFileUrl($path);

        return response()->json([
            'path' => $path,
            'url'  => $url,
        ]);
    }

    private function resolveFileUrl(string $path): ?string
    {
        $disk = $this->storageDisk();
        if (method_exists($disk, 'temporaryUrl')) {
            return $disk->temporaryUrl($path, now()->addHour());
        }

        $url = $disk->url($path);
        if (is_string($url) && str_starts_with($url, '/')) {
            $url = url($url);
        }

        return $url;
    }

    private function storageDiskName(): string
    {
        return 'gcs';
    }

    private function storageDisk()
    {
        return Storage::disk($this->storageDiskName());
    }
}
