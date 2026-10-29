<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    public function __construct(private readonly ProductImageService $images)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim($validated['search'] ?? '');

        $products = Product::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Product::class);

        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $data = $request->safe()->except('image');
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $this->images->store($request->file('image'));
            $data['image_path'] = $imagePath;
        }

        try {
            Product::create($data);
        } catch (Throwable $e) {
            // Don't leave an orphaned file behind if the insert fails.
            $this->images->delete($imagePath);

            throw $e;
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return view('products.edit', ['product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $data = $request->safe()->except('image');
        $oldPath = $product->image_path;
        $newPath = null;

        if ($request->hasFile('image')) {
            $newPath = $this->images->store($request->file('image'));
            $data['image_path'] = $newPath;
        }

        try {
            $product->update($data);
        } catch (Throwable $e) {
            $this->images->delete($newPath);

            throw $e;
        }

        if ($newPath !== null) {
            // The replacement is safely saved, so the old file can go.
            $this->images->delete($oldPath);
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $imagePath = $product->image_path;

        // Row first: an orphaned file is harmless, a broken image is not.
        $product->delete();
        $this->images->delete($imagePath);

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}