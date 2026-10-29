<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ProductImageService
{
    public const DISK = 'public';
    public const DIRECTORY = 'products';

    public function store(UploadedFile $image): string
    {
        $path = $image->store(self::DIRECTORY, self::DISK);

        if ($path === false) {
            throw new RuntimeException('The product image could not be stored.');
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        Storage::disk(self::DISK)->delete($path);
    }
}