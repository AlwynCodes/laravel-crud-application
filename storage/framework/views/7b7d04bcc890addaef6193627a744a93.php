<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
            <form method="post" action="<?php echo e(route('product.store')); ?>" class="p-6 space-y-4">
                <?php echo csrf_field(); ?>

                <?php if($errors->any()): ?>
                    <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Product Name *</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="e.g. Aqua Flask Tumbler"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">
                </div>

                <!-- Qty + Price -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Quantity *</label>
                        <input type="number" name="qty" value="<?php echo e(old('qty')); ?>" placeholder="0"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Price (₱) *</label>
                        <input type="number" step="0.01" name="price" value="<?php echo e(old('price')); ?>" placeholder="0.00"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" placeholder="Brief description..."
                              class="w-full border border-gray-300 rounded px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:border-blue-500"><?php echo e(old('description')); ?></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
                    <a href="<?php echo e(route('product.index')); ?>"
                       class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded hover:bg-gray-300"
                            style="color: black !important;">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\alwyn reuyan\laravel-crud-application\resources\views/products/create.blade.php ENDPATH**/ ?>