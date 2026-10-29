<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
                <a href="<?php echo e(route('product.index')); ?>"
                   class="text-amber-100 hover:text-white text-sm transition">
                    ← Back
                </a>
            </div>

            <form method="post" action="<?php echo e(route('product.update', ['product' => $product])); ?>" class="p-6 space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <?php if($errors->any()): ?>
                    <div class="p-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded text-sm">
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside text-xs">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>"
                           class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                  focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Qty + Price side by side -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="qty" value="<?php echo e(old('qty', $product->qty)); ?>"
                               class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                      focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                        <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Price (₱) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="price" value="<?php echo e(old('price', $product->price)); ?>"
                               class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                      focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-800
                                     focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"><?php echo e(old('description', $product->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="<?php echo e(route('product.index')); ?>"
                       class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800
                              bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600  text-sm font-semibold
                                   rounded-lg shadow-sm hover:shadow transition">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\alwyn reuyan\laravel-crud-application\resources\views/products/edit.blade.php ENDPATH**/ ?>