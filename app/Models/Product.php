<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qty',
        'price',
        'description',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'qty' => 'integer',
        ];
    }

    /**
     * Determine whether this product has an uploaded image.
     */
    public function hasImage(): bool
    {
        return filled($this->image_path);
    }

    /**
     * Public URL of the stored image, or null when there is none.
     */
    public function imageUrl(): ?string
    {
        return $this->hasImage()
            ? Storage::disk('public')->url($this->image_path)
            : null;
    }
}
