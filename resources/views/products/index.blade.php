<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Products</h1>
                <p class="text-sm text-gray-500 mt-1">Browse the product inventory.</p>
            </div>

            <div class="flex items-center gap-3">
                @if (auth()->user()->isAdmin())
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Admin</span>
                @else
                    <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-600 text-xs font-semibold">User</span>
                @endif

                @can('create', App\Models\Product::class)
                    <a href="{{ route('product.create') }}"
                       class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow">
                        + Add Product
                    </a>
                @endcan

                <a href="{{ url('/dashboard') }}"
                   class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm shadow-sm">
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Success message -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
        <form method="GET" action="{{ route('product.index') }}" class="mb-5 flex flex-col sm:flex-row gap-3">
            <input type="search" name="search" value="{{ $search }}"
                   placeholder="Search products by name..."
                   class="w-full sm:max-w-md border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

            <button type="submit"
                    class="px-5 py-2.5 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition">
                Search
            </button>

            @if ($search !== '')
                <a href="{{ route('product.index') }}"
                   class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition text-center">
                    Clear
                </a>
            @endif
        </form>

        @if ($search !== '')
            <p class="mb-4 text-sm text-gray-600">
                Results for <span class="font-semibold text-gray-900">&ldquo;{{ $search }}&rdquo;</span>
                &mdash; {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found.
            </p>
        @endif

        <!-- Product table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full table-auto">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Image</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Qty</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Description</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $product->id }}</td>

                            <td class="px-4 py-3">
                                <a href="{{ route('product.show', ['product' => $product]) }}">
                                    @if ($product->hasImage())
                                        <img src="{{ $product->imageUrl() }}"
                                             alt="{{ $product->name }}"
                                             class="h-14 w-14 rounded-lg object-cover ring-1 ring-gray-200">
                                    @else
                                        <div class="h-14 w-14 rounded-lg bg-gray-100 ring-1 ring-gray-200 flex items-center justify-center text-gray-300">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24">
                                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                                <path d="M4 16l5-5 3.5 3.5L16 12l4 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-800 font-medium">
                                <a href="{{ route('product.show', ['product' => $product]) }}" class="hover:text-blue-600">
                                    {{ $product->name }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-800">{{ $product->qty }}</td>

                            <td class="px-4 py-3 text-sm text-gray-800">&#8369;{{ number_format($product->price, 2) }}</td>

                            <td class="px-4 py-3 text-sm text-gray-600 max-w-md">
                                {{ Str::limit($product->description, 60) }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('product.show', ['product' => $product]) }}"
                                       class="px-3 py-1 bg-slate-200 text-gray-800 text-xs rounded hover:bg-slate-300 transition">
                                        View
                                    </a>

                                    @can('update', $product)
                                        <a href="{{ route('product.edit', ['product' => $product]) }}"
                                           class="px-3 py-1 bg-yellow-500 text-gray-900 text-xs rounded hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete', $product)
                                        <form action="{{ route('product.destroy', ['product' => $product]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this product and its image?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-gray-500">
                                @if ($search !== '')
                                    <p class="font-semibold text-gray-700">No products matched your search</p>
                                    <p class="mt-1">Nothing matched &ldquo;{{ $search }}&rdquo;. Try a different keyword.</p>
                                    <a href="{{ route('product.index') }}" class="inline-block mt-4 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                        Show all products
                                    </a>
                                @else
                                    <p class="font-semibold text-gray-700">No products yet</p>
                                    <p class="mt-1">Click &ldquo;+ Add Product&rdquo; to create the first one.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination + summary -->
        @if ($products->total() > 0)
            <div class="mt-5 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() }}&ndash;{{ $products->lastItem() }} of {{ $products->total() }} products
                </p>

                @if ($products->hasPages())
                    <div>{{ $products->links() }}</div>
                @endif
            </div>
        @endif
    </div>
</body>
</html>
