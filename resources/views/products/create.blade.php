<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg">

        <!-- Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">

            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4 rounded-t-lg">
                <h1 class="text-lg font-bold text-white">Create a Product</h1>
                <p class="text-blue-100 text-xs mt-0.5">Add a new item to your inventory</p>
            </div>

            <!-- Form -->
            <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                @if($errors->any())
                    <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                        <p class="font-semibold mb-1">Please fix the following {{ $errors->count() }} error(s):</p>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Product Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Aqua Flask Tumbler"
                           class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qty + Price -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="qty" class="block text-sm font-bold text-gray-700 mb-1">Quantity *</label>
                        <input type="number" id="qty" name="qty" value="{{ old('qty') }}" placeholder="0"
                               class="w-full border @error('qty') border-red-400 @else border-gray-300 @enderror rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">
                        @error('qty')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-1">Price (&#8369;) *</label>
                        <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" placeholder="0.00"
                               class="w-full border @error('price') border-red-400 @else border-gray-300 @enderror rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">
                        @error('price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Brief description..."
                              class="w-full border @error('description') border-red-400 @else border-gray-300 @enderror rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-1">Product Image</label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
                           class="w-full border @error('image') border-red-400 @else border-gray-300 @enderror rounded px-3 py-2 text-sm text-gray-700 bg-white file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Optional. JPEG, PNG or WebP, up to 2 MB.</p>
                    @error('image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
                    <a href="{{ route('product.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
