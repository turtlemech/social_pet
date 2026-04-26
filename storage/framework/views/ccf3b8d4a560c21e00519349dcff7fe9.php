<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'size' => 'md', 'src' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['name', 'size' => 'md', 'src' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $sizes = [
        'sm' => 'w-8 h-8',
        'md' => 'w-10 h-10',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16'
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    if(!$src) {
        $src = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0d9488&color=fff&bold=true';
    }
?>

<img src="<?php echo e($src); ?>" alt="<?php echo e($name); ?>" class="<?php echo e($sizeClass); ?> rounded-full object-cover"><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/social_pet/resources/views/components/ui/avatar.blade.php ENDPATH**/ ?>