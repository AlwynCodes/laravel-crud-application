<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 &middot; Forbidden</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-slate-200 p-8 text-center">

        <p class="text-xs font-semibold uppercase tracking-widest text-red-600">403 &middot; Forbidden</p>

        <h1 class="mt-3 text-xl font-bold text-slate-800">Administrator access required</h1>

        <p class="mt-3 text-sm text-slate-600 leading-relaxed">
            Your account can browse the product catalogue, but creating, editing, and deleting products
            is reserved for administrators.
        </p>

        <p class="mt-2 text-xs text-slate-500">
            If you believe you should have access, please contact the site administrator.
        </p>

        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
            <a href="<?php echo e(route('product.index')); ?>"
               class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                Back to products
            </a>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>"
                   class="px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                    Dashboard
                </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\alwyn reuyan\laravel-crud-application\resources\views/errors/403.blade.php ENDPATH**/ ?>