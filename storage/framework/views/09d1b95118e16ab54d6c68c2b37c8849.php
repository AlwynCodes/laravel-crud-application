<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4">
        <!-- Header with Add Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Products</h1>
            <a href="<?php echo e(route('product.create')); ?>"
               class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow">
                + Add Product
            </a>
        </div>

        <!-- Success message -->
        <?php if(session('success')): ?>
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded text-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Product table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full table-auto">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Qty</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Description</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-800"><?php echo e($product->id); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-800 font-medium"><?php echo e($product->name); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-800"><?php echo e($product->qty); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-800">₱<?php echo e(number_format($product->price, 2)); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-600 max-w-md">
                                <?php echo e(Str::limit($product->description, 60)); ?>

                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('product.edit', ['product' => $product])); ?>"
                                       class="px-3 py-1 bg-yellow-500  text-xs rounded hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('product.destroy', ['product' => $product])); ?>"
                                          method="POST"
                                          onsubmit="return confirm('Delete this product?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">
                                No products yet. Click "+ Add Product" to create one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\alwyn reuyan\laravel-crud-application\resources\views/products/index.blade.php ENDPATH**/ ?>