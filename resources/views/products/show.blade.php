<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">
    <div class="max-w-5xl mx-auto py-8 px-4">

        <!-- Breadcrumb + actions -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <a href="{{ route('product.index') }}" class="text-sm text-slate-500 hover:text-slate-800">
                &larr; Back to products
            </a>

            @can('update', $product)
                <div class="flex items-center gap-2">
                    <a href="{{ route('product.edit', ['product' => $product]) }}"
                       class="px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition">
                        Edit Product
                    </a>

                    <form action="{{ route('product.destroy', ['product' => $product]) }}" method="POST"
                          onsubmit="return confirm('Delete this product and its image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            @endcan
            <div class="flex items-center gap-2">
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">

            <!-- Image -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                @if ($product->hasImage())
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                         class="w-full aspect-[4/3] object-cover">
                @else
                    <div class="w-full aspect-[4/3] bg-slate-100 flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="M4 16l5-5 3.5 3.5L16 12l4 4"></path>
                        </svg>
                        <p class="mt-3 text-sm">No image uploaded</p>
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 flex flex-col">
                <h1 class="text-2xl font-bold text-slate-800">{{ $product->name }}</h1>

                <p class="mt-3 text-3xl font-bold text-blue-700">&#8369;{{ number_format($product->price, 2) }}</p>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    @if ($product->qty === 0)
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Out of stock</span>
                    @elseif ($product->qty < 10)
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">{{ $product->qty }} in stock</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">{{ $product->qty }} in stock</span>
                    @endif

                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium">Product #{{ $product->id }}</span>
                </div>

                <div class="mt-5 border-t border-slate-200 pt-4">
                    <h2 class="text-sm font-semibold text-slate-700">Description</h2>
                    <p class="mt-1.5 text-sm text-slate-600 leading-relaxed">
                        {{ $product->description ?: 'No description was provided for this product.' }}
                    </p>
                </div>

                <dl class="mt-auto pt-5 border-t border-slate-200 text-xs text-slate-500 space-y-1.5">
                    <div class="flex justify-between">
                        <dt>Added</dt>
                        <dd class="font-medium text-slate-700">{{ $product->created_at?->format('M j, Y g:i A') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Last updated</dt>
                        <dd class="font-medium text-slate-700">{{ $product->updated_at?->format('M j, Y g:i A') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</body>
</html>
