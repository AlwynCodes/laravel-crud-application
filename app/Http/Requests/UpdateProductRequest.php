<?php

namespace App\Http\Requests;

use App\Models\Product;

class UpdateProductRequest extends StoreProductRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $product = $this->route('product');

        return $product instanceof Product
            && ($this->user()?->can('update', $product) ?? false);
    }
}
