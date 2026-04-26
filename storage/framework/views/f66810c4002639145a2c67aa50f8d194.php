<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'SocialPet')); ?></title>

     <!--  FAVICON - Aquí se agrega el ícono de la pestaña  -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('storage/img/logo/social_pet.jpg')); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('storage/img/logo/social_pet.jpg')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('storage/img/logo/social_et.jpg')); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Styles -->
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('navigation-menu');

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2430583531-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <!-- Page Content -->
        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\laragon\www\social_pet\resources\views/layouts/app.blade.php ENDPATH**/ ?>