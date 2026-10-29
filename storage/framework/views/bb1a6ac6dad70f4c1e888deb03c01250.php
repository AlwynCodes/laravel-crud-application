<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($product->name); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-100 min-h-screen">
    <div class="max-w-5xl mx-auto py-8 px-4">

        <!-- Breadcrumb + actions -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <a href="<?php echo e(route('product.index')); ?>" class="text-sm text-slate-500 hover:text-slate-800">
                &larr; Back to products
            </a>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $product)): ?>
                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('product.edit', ['product' => $product])); ?>"
                       class="px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition">
                        Edit Product
                    </a>

                    <form action="<?php echo e(route('product.destroy', ['product' => $product])); ?>" method="POST"
                          onsubmit="return confirm('Delete this product and its image?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded text-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid gap-6 lg:grid-cols-2">

            <!-- Image -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <?php if($product->hasImage()): ?>
                    <img src="<?php echo e($product->imageUrl()); ?>" alt="<?php echo e($product->name); ?>"
                         class="w-full aspect-[4/3] object-cover">
                <?php else: ?>
                    <div class="w-full aspect-[4/3] bg-slate-100 flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                            <path d="M4 16l5-5 3.5 3.5L16 12l4 4"></path>
                        </svg>
                        <p class="mt-3 text-sm">No image uploaded</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 flex flex-col">
                <h1 class="text-2xl font-bold text-slate-800"><?php echo e($product->name); ?></h1>

                <p class="mt-3 text-3xl font-bold text-blue-700">&#8369;<?php echo e(number_format($product->price, 2)); ?></p>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <?php if($product->qty === 0): ?>
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Out of stock</span>
                    <?php elseif($product->qty < 10): ?>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold"><?php echo e($product->qty); ?> in stock</span>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"><?php echo e($product->qty); ?> in stock</span>
                    <?php endif; ?>

                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium">Product #<?php echo e($product->id); ?></span>
                </div>

                <div class="mt-5 border-t border-slate-200 pt-4">
                    <h2 class="text-sm font-semibold text-slate-700">Description</h2>
                    <p class="mt-1.5 text-sm text-slate-600 leading-relaxed">
                        <?php echo e($product->description ?: 'No description was provided for this product.'); ?>

                    </p>
                </div>

                <dl class="mt-auto pt-5 border-t border-slate-200 text-xs text-slate-500 space-y-1.5">
                    <div class="flex justify-between">
                        <dt>Added</dt>
                        <dd class="font-medium text-slate-700"><?php echo e($product->created_at?->format('M j, Y g:i A')); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Last updated</dt>
                        <dd class="font-medium text-slate-700"><?php echo e($product->updated_at?->format('M j, Y g:i A')); ?></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\alwyn reuyan\laravel-crud-application\resources\views/products/show.blade.php ENDPATH**/ ?>