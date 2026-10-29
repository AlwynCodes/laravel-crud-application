<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Product::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'qty' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name may not be longer than 255 characters.',
            'price.min' => 'The price cannot be negative.',
            'qty.integer' => 'The quantity must be a whole number.',
            'qty.min' => 'The quantity cannot be negative.',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.mimes' => 'Only JPEG, PNG, and WebP images are accepted.',
            'image.max' => 'The image may not be larger than 2 MB.',
        ];
    }
}