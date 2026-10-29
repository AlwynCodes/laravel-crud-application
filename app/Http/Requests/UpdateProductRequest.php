<?php

namespace App\Http\Requests;

use App\Models\Product;

class UpdateProductRequest extends StoreProductRequest
{
    public function authorize(): bool
    {
        $product = $this->route('product');

        return $product instanceof Product
            && ($this->user()?->can('update', $product) ?? false);
    }
}