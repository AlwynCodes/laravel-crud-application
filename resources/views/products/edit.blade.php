<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            <!-- Header (amber for edit) -->
            <div class="bg-amber-500 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-white">Edit Product</h1>
                    <p class="text-amber-100 text-xs mt-0.5">Update the product details</p>
                </div>
                <a href="{{ route('product.show', ['product' => $product]) }}"
                   class="text-amber-100 hover:text-white text-sm transition">
                    &larr; Back
                </a>
            </div>

            <form method="post" action="{{ route('product.update', ['product' => $product]) }}" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="p-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded text-sm">
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside text-xs">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                           class="w-full border @error('name') border-red-400 @else border-slate-300 @enderror rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                  focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Qty + Price side by side -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="qty" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="qty" name="qty" value="{{ old('qty', $product->qty) }}"
                               class="w-full border @error('qty') border-red-400 @else border-slate-300 @enderror rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                      focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                        @error('qty') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Price (&#8369;) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}"
                               class="w-full border @error('price') border-red-400 @else border-slate-300 @enderror rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                      focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                        @error('price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full border @error('description') border-red-400 @else border-slate-300 @enderror rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                     focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-700 mb-1.5">Product Image</label>

                    @if ($product->hasImage())
                        <div class="mb-2 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-2">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                                 class="h-16 w-16 rounded-lg object-cover ring-1 ring-slate-200">
                            <div class="text-xs text-slate-600">
                                <p class="font-medium text-slate-800">Current image</p>
                                <p class="break-all">{{ $product->image_path }}</p>
                                <p class="mt-0.5">Upload a new file to replace it. The old file is deleted only after the new one is saved.</p>
                            </div>
                        </div>
                    @endif

                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
                           class="w-full border @error('image') border-red-400 @else border-slate-300 @enderror rounded-lg px-3 py-2 text-sm text-slate-700 bg-white file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    <p class="mt-1 text-xs text-slate-500">Optional. JPEG, PNG or WebP, up to 2 MB.</p>
                    @error('image') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('product.index') }}"
                       class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800
                              bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold
                                   rounded-lg shadow-sm hover:shadow transition">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
