<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ProductImageService
{
    /**
     * The disk that stores publicly reachable product images.
     */
    public const DISK = 'public';

    /**
     * The directory, relative to the disk root, that holds product images.
     */
    public const DIRECTORY = 'products';

    /**
     * Store an uploaded image and return its path relative to the disk root.
     */
    public function store(UploadedFile $image): string
    {
        $path = $image->store(self::DIRECTORY, self::DISK);

        if ($path === false) {
            throw new RuntimeException('The product image could not be stored.');
        }

        return $path;
    }

    /**
     * Delete a stored image, ignoring an empty or missing path.
     */
    public function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        Storage::disk(self::DISK)->delete($path);
    }
}
